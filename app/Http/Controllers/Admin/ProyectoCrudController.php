<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProyectoRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProyectoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProyectoCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Proyecto::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/proyecto');
        CRUD::setEntityNameStrings('proyecto', 'proyectos');
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
        CRUD::column('nombre')->type('text')->label('Proyecto');
        CRUD::addColumn([
            'name'         => 'Tareas', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Tareas', // Table column heading
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
        CRUD::setValidation(ProyectoRequest::class);
        CRUD::field('nombre')->type('text')->label('Proyecto');
        CRUD::field('jefe_proyecto')->type('text')->label('Jefe de proyecto');
        CRUD::addField([
            'label'     => "Tareas",
            'placeholder'=> 'Seleccione una tarea',
            'type'      => "relationship",
            'name'      => 'tareas', // the method on your model that defines the relationship
            'inline_create' => ['entity' => 'tarea', ] // the entity in singular]
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
        $this->crud->removeField('tareas');
    }

    /**
     * Fetch de tareas para campo relationship
     */
    protected function fetchTareas()
    {
        return $this->fetch(\App\Models\Tarea::class);
    }

}
