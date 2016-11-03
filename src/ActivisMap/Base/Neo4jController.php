<?php
namespace ActivisMap\Base;

use ActivisMap\Entity\Activity;
use ActivisMap\Entity\Alert;
use ActivisMap\Entity\Application;
use ActivisMap\Entity\User;
use HireVoice\Neo4j\Repository;
use ActivisMap\Entity\NeoUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Created by PhpStorm.
 * User: ander
 * Date: 17/06/16
 * Time: 13:29
 */
class Neo4jController extends ApiController {

    /**
     * @return \HireVoice\Neo4j\Repository
     * @throws \HireVoice\Neo4j\Exception
     */
    public function getApplicationRepository() {
        return $this->getNeoManager()->getRepository('ActivisMap\Entity\Application');
    }


    /**
     * @return \HireVoice\Neo4j\Repository
     * @throws \HireVoice\Neo4j\Exception
     */
    public function getUserRepository() {
        return $this->getNeoManager()->getRepository('ActivisMap\Entity\NeoUser');
    }

    /**
     * @return \HireVoice\Neo4j\Repository
     * @throws \HireVoice\Neo4j\Exception
     */
    public function getActivityRepository() {
        return $this->getNeoManager()->getRepository('ActivisMap\Entity\Activity');
    }

    /**
     * @return \HireVoice\Neo4j\Repository
     * @throws \HireVoice\Neo4j\Exception
     */
    public function getAlertRepository() {
        return $this->getNeoManager()->getRepository('ActivisMap\Entity\Alert');
    }

    /**
     * @param Request $request
     * @param Repository $repository
     * @param array $criteria
     * @return array
     */
    public function indexAction($request, $repository, $criteria = array()) {
        $limit = 10;
        $offset = 0;

        if ($request->request->has('limit')) {
            $limit = $request->request->get('limit');
        }

        if ($request->request->has('offset')) {
            $offset = $request->request->get('offset');
        }

        if (!empty($criteria)) {
            $all = $repository->findBy($criteria)->getValues();
        } else {
            $all = $repository->findAll()->getValues();
        }

        $total = count($all);

        $entities = array_slice($all, $offset, $limit);

        $data = array(
            'total' => $total,
            'start' => intval($offset),
            'end' => (count($entities)+$offset-1)>0?(count($entities)+$offset-1):0,
            'elements' => $entities
        );

        return $data;
    }

    /**
     * @param null $id
     * @param bool $checkNull
     * @return NeoUser
     */
    protected function getNeoUser($id = null, $checkNull = false) {
        $user = $this->getUser();

        /** @var NeoUser $neoUser */
        $neoUser = $this->getUserRepository()
            ->find($id == null ? $user->getNeoId() : $id);

        if ($checkNull) {
            $this->checkNull($neoUser, 'User not found.');
        }

        return $neoUser;
    }

    /**
     * @param User $entity
     * @param Application $app
     * @return NeoUser
     */
    public function saveUser(User $entity, Application $app) {
        $neoId = $entity->getNeoId();
        if ($neoId != null && $neoId > -1) {
            $neoUser = $this->getNeoUser($neoId);
            $neoUser = $entity->toNeoUser($neoUser);
        } else {
            $neoUser = $entity->toNeoUser();
        }

        $neoUser->setApplication($app);

        $this->saveInNeo($neoUser);
        die(print_r('caca', true));
        $entity->setNeoId($neoUser->getId());
        $this->save($entity);

        return $neoUser;
    }

    /**
     * @param Repository $repository
     * @param $id
     * @return bool|\Everyman\Neo4j\Node
     */
    protected function getNeoEntity($repository, $id) {
        return $repository
            ->find($id);
    }

    /**
     * @param Request $request
     * @param Repository $repository
     * @param $id
     * @return \Everyman\Neo4j\Node|null
     */
    protected function update(Request $request, Repository $repository, $id) {

        if(empty($id)) throw new HttpException(400, "Missing parameter 'id'");

        $params = $request->request->all();

        $entity = $repository->findOneBy(array('id'=>$id));

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

        $this->saveInNeo($entity);

        return $entity;
    }

    protected function attributeToSetter($str) {
        $func = create_function('$c', 'return strtoupper($c[1]);');
        return preg_replace_callback('/_([a-z])/', $func, "set_".$str);
    }

    /**
     * @param $params
     * @param Repository $repository
     * @param $id
     * @return \Everyman\Neo4j\Node|null
     */
    protected function updateFromParams($params, Repository $repository, $id) {

        if(empty($id)) throw new HttpException(400, "Missing parameter 'id'");

        $entity = $repository->findOneBy(array('id'=>$id));

        if(empty($entity)) throw new HttpException(404, "Not found");

        foreach ($params as $name => $value) {
            if ($name != 'id') {
                $setter = $this->attributeToSetter($name);
                if (method_exists($entity, $setter)) {
                    call_user_func(array($entity, $setter), $value);
                }
            }
        }

        $this->saveInNeo($entity);

        return $entity;
    }


    public function delete(Request $request, Repository $repo, $id){
        if(empty($id)) throw new HttpException(400, "Missing parameter 'id'");

        $entity = $repo->findOneBy(array('id'=>$id));

        if(empty($entity)) throw new HttpException(404, "Not found");

        $this->deleteEntity($entity);

        return $this->rest(null, "success", "Deleted successfully");
    }

    /**
     * @param $id
     * @param bool $checkNull
     * @return Application
     */
    public function getApplication($id, $checkNull = true) {
        /** @var Application $object */
        $object = $this->getNeoEntity($this->getApplicationRepository(), $id);
        if ($checkNull) {
            $this->checkNull($object, 'Application not found.');
        }

        $object->prepare();
        return $object;

    }

    /**
     * @param $id
     * @param bool $checkNull
     * @return Activity
     */
    public function getActivity($id, $checkNull = true) {
        /** @var Activity $object */
        $object = $this->getNeoEntity($this->getActivityRepository(), $id);
        if ($checkNull) {
            $this->checkNull($object, 'Activity not found.');
        }

        $object->prepare();
        return $object;

    }

    /**
     * @param $id
     * @param bool|true $checkNull
     * @return Alert
     */
    public function getAlert($id, $checkNull = true) {
        /** @var Alert $object */
        $object = $this->getNeoEntity($this->getAlertRepository(), $id);
        if ($checkNull) {
            $this->checkNull($object, 'Alert not found.');
        }

        $object->prepare();
        return $object;

    }

    /**
     * @param array $data
     * @return array
     */
    public function prepare(array $data) {
        foreach ($data as $d) {
            $d->prepare();
        }

        return $data;
    }

    /**
     * @param BaseEntity $entity
     */
    public function saveInNeo(BaseEntity $entity) {
        $entity->setLastUpdate();
        $neoM = $this->getNeoManager();
        $neoM->persist($entity);
        $neoM->flush();
    }

    public function deleteEntity($entity) {
        $em = $this->getNeoManager();
        $em->remove($entity);
        $em->flush();
    }
}