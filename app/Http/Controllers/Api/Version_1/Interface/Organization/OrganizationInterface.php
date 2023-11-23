<?php
namespace App\Http\Controllers\Api\Version_1\Interface\Organization;

interface OrganizationInterface
{
    public function getTempOrganizationDataByTempId($tempOrgId);
    public function storeTempOrganization($model);
    public function pimsOrganizationStructure();
    public function pimsOrganizationCategory();
    public function pimsOrganizationOwnerShip();
    public function pimsOrganizationDocumentType();
    public function getOrganizationAccountByUid($uid);
    public function changeDefaultOrganization($uid);
    public function getOrganizationName($uid);
    public function getAllTempOrganizations($uid);








}
