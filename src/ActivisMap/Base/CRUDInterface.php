<?php
/**
 * Created by PhpStorm.
 * User: lluis
 * Date: 11/15/14
 * Time: 8:52 PM
 */

namespace ActivisMap\Base;



use Symfony\Component\HttpFoundation\Request;

interface CRUDInterface{
    public function index(Request $request);
    public function show(Request $request, $id);
    public function create(Request $request);
    public function update(Request $request, $id);
    public function delete(Request $request, $id);
}