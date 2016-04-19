<?php

namespace AppBundle\Base;

use AppBundle\Entity\User;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class CRUDApiController extends ApiController implements CRUDInterface{

    protected abstract function getRepositoryName();

    protected function getRepository(){
        return $this->getDoctrine()
            ->getManager()
            ->getRepository($this->getRepositoryName());
    }

    public function indexAction(Request $request){

        if($request->query->has('limit')) $limit = $request->query->get('limit');
        else $limit = 10;

        if($request->query->has('offset')) $offset = $request->query->get('offset');
        else $offset = 0;

        //TODO: Improve performance (two queries)
        $all = $this->getRepository()->findAll();

        $total = count($all);

        $entities = array_slice($all, $offset, $limit);

        return $this->rest(
            array(
                'total' => $total,
                'start' => intval($offset),
                'end' => (count($entities)+$offset-1)>0?(count($entities)+$offset-1):0,
                'elements' => $entities
            ),
            "success",
            "Request successful"
        );
    }

    public function showAction(Request $request, $id){
        if(empty($id)) throw new HttpException(400, "Missing parameter 'id'");

        $repo = $this->getRepository();

        $entities = $repo->findOneBy(array('id'=>$id));

        if(empty($entities)) throw new HttpException(404, "Not found");

        return $this->rest($entities, "success", "Request successful");
    }

    public function createEntity(Request $request){
        $entity = $this->getNewEntity();

        $params = $request->request->all();

        foreach ($params as $name => $value) {
            if ($name != 'id') {
                $setter = $this->attributeToSetter($name);
                if (method_exists($entity, $setter)) {
                    call_user_func_array(array($entity, $setter), array($value));
                }
            }
        }

        return $entity;
    }

    protected function save($entity) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        try{
            $em->flush();
        } catch(DBALException $e){
            if(preg_match('/1062 Duplicate entry/i',$e->getMessage()))
                throw new HttpException(409, "Duplicated resource");
            else if(preg_match('/1048 Column/i',$e->getMessage()))
                //throw $e;
                throw new HttpException(400, "Bad parameters: " . $e->getMessage());
            throw new HttpException(500, "Unknown error occurred when save");
        }
    }

    protected function createAction(Request $request){
        $entity = $this->createEntity($request);
        $this->save($entity);
        return $this->rest($entity);
    }

    public function updateAction(Request $request, $id){

        if(empty($id)) throw new HttpException(400, "Missing parameter 'id'");

        $params = $request->request->all();

        $repo = $this->getRepository();

        $entity = $repo->findOneBy(array('id'=>$id));

        if(empty($entity)) throw new HttpException(404, "Not found");

        foreach ($params as $name => $value) {
            if ($name != 'id') {
                $setter = $this->attributeToSetter($name);
                if (method_exists($entity, $setter)) {
                    call_user_func(array($entity, $setter), $value);
                }
                else{
                    throw new HttpException(400, "Bad request, parameter '$name' is not allowed");
                }
            }
        }

        $this->save($entity);

        return $this->rest(null, "success", "Updated successfully");
    }

    public function deleteAction(Request $request, $id){
        if(empty($id)) throw new HttpException(400, "Missing parameter 'id'");

        $repo = $this->getRepository();

        $entity = $repo->findOneBy(array('id'=>$id));

        if(empty($entity)) throw new HttpException(404, "Not found");

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->rest(null, "success", "Deleted successfully");
    }

    private function attributeToSetter($str) {
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, "set_".$str);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager() {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return User
     */
    protected function getUser() {
        return $this->container->get("security.token_storage")->getToken()->getUser();
    }

    protected function _checkParams(Request $request, array $params) {
        $req_params = array();
        foreach ($params as $param) {
            if(!$request->request->has($param)) {
                throw new HttpException(400, "Param '" . $param . "' not found");
            } else {
                $req_params[$param] = $request->request->get($param);
            }
        }

        return $req_params;
    }
}