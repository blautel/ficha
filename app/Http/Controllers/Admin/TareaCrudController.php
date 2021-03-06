<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TareaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TareaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TareaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;


    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Tarea::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tarea');
        CRUD::setEntityNameStrings('tarea', 'tareas');
        $this->crud->denyAccess('show');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::column('nombre')->type('text')->label('Tarea');
        CRUD::addColumn([
            'name'         => 'Proyectos', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Proyectos', // Table column heading
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TareaRequest::class);
        CRUD::field('nombre')->type('text')->label('Tarea');
        CRUD::addField([
                'label' => 'Proyectos',
                'placeholder'=> 'Seleccione un proyecto',
                'type' => 'relationship',
                'name' => 'proyectos', // the method on your model that defines the relationship
                'inline_create' => [ 'entity' => 'proyecto' ] // specify the entity in singular
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Eliminar campo Tareas en la creación inline
     *
     * @return void
     */
    protected function setupInlineCreateOperation()
    {
        $this->crud->removeField('proyectos');
    }

    /**
     * Fetch de proyectos para campo relationship
     */
    protected function fetchProyectos()
    {
        return $this->fetch(\App\Models\Proyecto::class);
    }

}


