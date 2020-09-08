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
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
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
        //CRUD::setFromDb(); // columns

        CRUD::column('nombre')->type('text')->label('Proyecto');


        CRUD::addColumn([

            'name'         => 'Tareas', // name of relationship method in the model
            'type'         => 'relationship',
            'label'        => 'Tareas', // Table column heading
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
        CRUD::setValidation(ProyectoRequest::class);

        // CRUD::setFromDb(); // fields

        CRUD::field('nombre')->type('text')->label('Proyecto');
        CRUD::field('jefe_proyecto')->type('text')->label('Jefe de proyecto');

        CRUD::addField([
            'label'     => "Tareas",
            'type'      => "relationship",
            'name'      => 'tareas', // the method on your model that defines the relationship
            //'ajax'      => true,
            'inline_create' => [
                'entity'         => 'tarea', // the entity in singular
                //'modal_class'   => 'modal-dialog modal-xl', // use modal-sm, modal-lg modal-xl
                ], // assumes the URL will be "/admin/category/inline/create"
    ]);
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
        CRUD::setValidation(ProyectoRequest::class);

        $this->setupCreateOperation();
    }

    /**
     * Sobreescribimos la funcion que nos crea el formulario en el inline
     * para que no nos muestre el campo proyecto
     */

    protected function fetchTareas()
    {
        return $this->fetch(App\Models\Proyecto::class);
    }
}
