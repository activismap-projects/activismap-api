<?php

namespace ActivisMap\Base;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class EntityController extends ApiController {

    protected abstract function getRepositoryName();

    protected function getRepository(){
        return $this->getDoctrine()
            ->getManager()
            ->getRepository($this->getRepositoryName());
    }

    public function index(Request $request){

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

    /**
     * @param Request $request
     * @param $id
     * @return object
     */
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
            }
        }

        $this->save($entity);

        return $entity;
    }

    public function deleteAction($id){
        if(empty($id)) throw new HttpException(400, "Missing parameter 'id'");

        $repo = $this->getRepository();

        $entity = $repo->find(array('id'=>$id));

        if(empty($entity)) throw new HttpException(404, "Not found");

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->rest(null, "success", "Deleted successfully");
    }
}