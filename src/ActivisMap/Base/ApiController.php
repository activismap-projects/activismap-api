<?php

namespace ActivisMap\Base;

use ActivisMap\Entity\User;
use ActivisMap\Util\GCMSender;
use Doctrine\DBAL\DBALException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use HireVoice\Neo4j\EntityManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;


class ApiController extends FOSRestController{

    public function rest($data = null, $status = "ok", $message = "Request success", $httpCode = 200){
        $response = new ApiResponse(
            $data,$status,$message
        );
        return $this->handleView($this->view($response, $httpCode));
    }

    public function save($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        try{
            $em->flush();
        } catch(DBALException $e){
            if(preg_match('/1062 Duplicate entry/i',$e->getMessage())) {
                throw new HttpException(409, "Duplicated resource, " . $e->getMessage());
            } else if(preg_match('/1048 Column/i',$e->getMessage())) {
                //throw $e;
                throw new HttpException(400, "Bad parameters: " . $e->getMessage());
            }
            throw new HttpException(500, "Unknown error occurred when save " . $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $entity
     * @param array $array
     * @param bool $throwError
     * @return bool
     */
    protected function checkExist(Request $request, $entity, array $array, $throwError = true){
        $em = $this->getDoctrine()->getManager();
        for($i = 0; $i < sizeof($array); $i++){
            $aux = trim($request->get($array[$i]));
            if($em->getRepository('ActivisMap:'.$entity)->findOneBy(array($array[$i] => $aux))){
                if ($throwError) {
                    throw new HttpException(409, $array[$i] . " '" . $aux . "' already used");
                }

                return true;
            }
        }

        return false;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger() {
        return $this->get('logger');
    }

    /**
     * @param $object
     * @param $message
     * @param bool|true $throwError
     * @return bool
     */
    protected function checkNull($object, $message, $throwError = true) {
        if ($object == null || $object == false) {
            if ($throwError) {
                throw new HttpException(404, $message);
            }

            return true;
        }

        return false;
    }

    /**
     * @return User
     */
    protected function getUser() {
        return $this->container->get("security.token_storage")->getToken()->getUser();
    }

    /**
     * @param Request $request
     * @param array $params
     * @param array $optional_params
     * @return array
     */
    protected function checkParams(Request $request, array $params, $optional_params = array()) {
        $req_params = array();

        foreach ($params as $param) {
            if ($request->request->has($param)) {
                $val = $request->request->get($param);
                if ($val != '') {
                    $req_params[$param] = $val;
                } else {
                    throw new HttpException(400, "Param '" . $param . "' is required.");
                }
            } else if ($request->query->has($param)) {
                $val = $request->query->get($param);
                if ($val != '') {
                    $req_params[$param] = $val;
                } else {
                    throw new HttpException(400, "Param '" . $param . "' is required.");
                }
            } else {
                throw new HttpException(400, "Param '" . $param . "' is required.");
            }
        }

        foreach ($optional_params as $op) {
            if ($request->request->has($op)) {
                $val =  $request->request->get($op);
                if ($val != '') {
                    $req_params[$op] = $val;
                }

            } else if ($request->query->has($op)) {
                $val =  $request->query->get($op);
                if ($val != '') {
                    $req_params[$op] = $val;
                }
            }
        }

        return $req_params;
    }

    /**
     * @param Request $request
     * @param array $params
     * @param array $optional_files
     * @return array
     */
    protected function checkFiles(Request $request, array $params, $optional_files = array()) {
        $req_files = array();
        foreach ($params as $param) {
            if(!$request->files->has($param)) {
                throw new HttpException(400, "File param '" . $param . "' not provided.");
            } else {
                $req_files[$param] = $request->files->get($param);
            }
        }

        foreach ($optional_files as $op) {
            if ($request->files->has($op) && !empty($request->files->get($op))) {
                $req_files[$op] = $request->files->get($op);
            }
        }

        return $req_files;
    }

    /**
     * @param UploadedFile $tempFile
     * @return array
     */
    public function saveFile($tempFile) {
        $filepath = $this->get('kernel')->getRootDir() . "/../web/files/";

        $filename = $tempFile->getClientOriginalName();
        if ($filename != '') {
            $ext = substr($filename, strpos($filename, '.'), strlen($filename));
            $filename = uniqid() . $ext;

            $f = fopen($tempFile, 'rb');
            $content = fread($f, filesize($tempFile));
            $fs = new Filesystem();
            $fs->dumpFile($filepath . $filename, $content);
            fclose($f);

            $baseUrl = "https://" . $_SERVER['HTTP_HOST'];

            $data = array();
            $data['local_path'] = $filepath . $filename;
            $data['url'] = $baseUrl . '/files/' . $filename;
            $data['size'] = filesize($filepath . $filename);
            $data['mimeType'] = $tempFile->getClientMimeType();
            return $data;
        }

        throw new HttpException(400, 'Invalid file or filename');
    }

    /**
     * @param string $filename
     * @param string $file
     * @return array
     */
    public function saveFile64($filename, $file) {
        $filepath = $this->get('kernel')->getRootDir() . "/../web/files/";

        if ($file != '' && $filename != '') {
            $ext = substr($filename, strpos($filename, '.'), strlen($filename));
            $filename = uniqid() . $ext;
            $fs = new Filesystem();
            $fs->dumpFile($filepath . $filename, base64_decode($file));

            $baseUrl = "https://" . $_SERVER['HTTP_HOST'];

            $data = array();
            $data['local_path'] = $filepath . $filename;
            $data['url'] = $baseUrl . '/files/' . $filename;
            $data['size'] = filesize($filepath . $filename);
            $data['mimeType'] = mime_content_type($filepath.$filename);

            return $data;
        }

        throw new HttpException(400, 'Invalid file or filename');
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function getManager() {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return EntityManager
     */
    public function getNeoManager() {
        return $this->get('neo4j.entity_manager');
    }

    /**
     * @return NeoQuery
     */
    public function getNeoQuery() {
        return new NeoQuery($this->getNeoManager());
    }

    /**
     * @return int
     */
    public function getMilliseconds() {
        return (int) round(microtime(true) * 1000);
    }

    /**
     * @return GCMSender
     */
    protected function getGCMSender() {
        return new GCMSender($this->getManager());
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter($name) {
        return $this->container->getParameter($name);
    }

    /**
     * @param integer $id
     * @return User
     */
    protected function getUserById($id) {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository('ActivisMap:User')->find($id);
    }

    /**
     * @return \Swift_Mailer
     */
    public function getMailer() {
        return $this->container->get('mailer');
    }

    /**
     * @param string $templateName
     * @param array $body
     * @param string $subject
     * @param string $from
     * @param array $to
     * @param string $contentType
     * @param array $bcc
     */
    public function sendMail($templateName, $body, $subject, $from, $to,  $bcc = array(), $contentType = 'text/html') {
        $email = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setBcc($bcc)
            ->setTo($to);


        $template = $this->container->get('templating')->render($templateName, $body);
        $email->setBody($template)
            ->setContentType($contentType);
        $this->getMailer()->send($email);
    }
}
