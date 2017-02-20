<?php
use Modules\BusinessLogic\Search\RightSearch;
use Modules\BusinessLogic\Search\RoleSearch;
use Modules\BusinessLogic\Search\SeqSearch;

class DatabaseTask extends TaskBase
{

    public function mainAction(){
        echo "database generate".PHP_EOL;
        echo "database reset".PHP_EOL;
    }

    /**
     * Kiolvassa a rights.json-ból az adatokat és feltölti az adatbázisba
     */
    private function createRights(){
        $this->resetRights();

        $rightSearch = RightSearch::createRightSearch();
        $rightSearch->disableCache();
        $right_string = file_get_contents(__DIR__."/files/rights.json");

        $right_obj = json_decode($right_string,true);
        foreach ($right_obj['rights'] as $right){
            $right = (object)$right;
            /**@var \Modules\BusinessLogic\ContentSettings\Right $newRight*/
            $newRight = $rightSearch->create();
            $newRight->name = $right->name;
            $newRight->code = $right->code;
            $newRight->type = $right->type;
            $newRight->parent = $right->parent;
            $newRight->actions = $right->actions;
            $newRight->save();
        }
    }

    /**
     * kitörli a jogokat az adatbázisból és visszaállítja az id-t
     */
    private function resetRights(){
        $rightSearch = RightSearch::createRightSearch();
        $rightSearch->disableCache();
        $rightSearch->type = "group";
        $rights = $rightSearch->find();
        /** @var \Modules\BusinessLogic\ContentSettings\Right $right */
        foreach ($rights as $right){
            $right->delete();
        }

        $seqSearch = SeqSearch::createSeqSearch();
        $seqSearch->disableCache();
        /** @var \Modules\BusinessLogic\ContentSettings\Seqs $seq */
        $seq = $seqSearch->create('rights');
        if($seq){
            $seq->delete();
        }

    }

    /**
     * kiolvassa a szerepköröket és feltölti az adatbázisba
     */
    private function createRoles(){
        $this->resetRoles();

        $roleSearch = RoleSearch::createRoleSearch();
        $roleSearch->disableCache();
        $role_string = file_get_contents(__DIR__."/files/roles.json");

        $role_obj = json_decode($role_string,true);
        foreach ($role_obj['roles'] as $role){
            $role = (object)$role;
            /**@var \Modules\BusinessLogic\ContentSettings\Role $newRole*/
            $newRole = $roleSearch->create();
            $newRole->name = $role->name;
            $newRole->code = $role->code;
            $newRole->type = $role->type;
            $newRole->rights = $role->rights;
            $newRole->roles = $role->roles;
            $newRole->save();
        }
    }

    /**
     * kitörli a szerepköröket az adatbázisból és visszaállítja az id-t
     */
    private function resetRoles(){
        $roleSearch = RoleSearch::createRoleSearch();
        $roleSearch->disableCache();
        $roles = $roleSearch->find();
        /** @var \Modules\BusinessLogic\ContentSettings\Role $role */
        foreach ($roles as $role){
            $role->delete();
        }

        $seqSearch = SeqSearch::createSeqSearch();
        $seqSearch->disableCache();
        /** @var \Modules\BusinessLogic\ContentSettings\Seqs $seq */
        $seq = $seqSearch->create('roles');
        if($seq){
            $seq->delete();
        }
    }

    /**
     * legenerálja a jogosultságokat
     */
    public function generateAction() {
        $this->createRights();
        $this->createRoles();
    }

    public function resetAction() {
        $this->createRights();
        $this->createRoles();
    }
}