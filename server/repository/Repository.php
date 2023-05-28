<?php
namespace Server\Repository;
interface IRepository
{
    public function fetchAll();
    public function fetchByID(string $id);
    public function create($entity);
    public function update($entity);
    public function delete($entity);
}