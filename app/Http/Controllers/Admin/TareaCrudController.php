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
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;


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
        //CRUD::setFromDb(); // columns

        CRUD::column('nombre')->type('text')->label('Tarea');
        CRUD::addColumn([

            'label'     => "Proyecto",
            'type'      => 'select',
            'name'      => 'id_proyecto', // the db column for the foreign key
            'entity'    => 'proyecto',
            'model'     => "App\Models\Proyecto", // related model
            'attribute' => 'nombre' // foreign key attribute that is shown to user
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */


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

        //CRUD::setFromDb(); // fields

        CRUD::addfield([
            'label'     => "Proyecto",
            'type'      => 'select',
            'name'      => 'id_proyecto', // the db column for the foreign key
            'entity'    => 'proyecto',
            'model'     => "App\Models\Proyecto", // related model
            'attribute' => 'nombre' // foreign key attribute that is shown to user

        ]);

        CRUD::field('nombre')->type('text')->label('Tarea');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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

}


