<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JornadaRequest;
use App\Http\Requests\CreateJornadaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class JornadaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class JornadaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { edit as protected editTrait; update as protected updateTrait; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Jornada::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/jornada');
        CRUD::setEntityNameStrings('jornada', 'jornadas');
        $this->crud->denyAccess('show');
        $this->crud->set('create.view', 'crud::jornada.create');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */

        if (backpack_user()->hasRole('administrador')) {
            CRUD::column('nombre')->type('text')->label('Nombre');
        }
        CRUD::column('created_at')->type('datetime')->label('Hora inicio');
        CRUD::column('final')->type('datetime')->label('Final');
        CRUD::addColumn([
            'name' => 'duracion',
            'type' => 'text',
            'label' => 'Duración',
            'wrapper'   => [
                'element' => 'span',
                'id' => function ($crud, $column, $entry) {
                    return 'dur-id-'.$entry->id;
                },
                'class' => function ($crud, $column, $entry) {
                    return $entry->final ? '' : 'text-success';
                },
            ],
            'prefix' => function ($crud, $column, $entry) {
                return $entry->final ? '' : '<i class="la la-clock-o"></i>';
            },
        ]);
        CRUD::column('descripcion')->type('text')->label('Descripción');

        // cambiar el botón de "edit" (acción update) por el de "finalizar jornada"
        $this->crud->removeButton('update');
        $this->crud->addButtonFromView('line', 'finalizar', 'finalizar_jornada', 'beginning');
        // El control de acceso se realiza en:
        // - vista boton finalizar_jornada
        // - edit() y update() (ver final fichero)

        // cambiar el botón de "edit" por el de "iniciar jornada"
        $this->crud->removeButtonFromStack('create', 'top');
        $this->crud->addButtonFromView('top', 'iniciar', 'iniciar_jornada', 'beginning');

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CreateJornadaRequest::class);

        // CRUD::setFromDb(); // fields

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
        CRUD::setValidation(JornadaRequest::class);
        CRUD::field('created_at')
            ->type('datetime')
            ->label('Hora inicio')
            ->attributes(['disabled' => 'disabled'])
            ->wrapper([
                'class'      => 'form-group col-md-6'
             ]);
        CRUD::field('duracion')
            ->type('text')
            ->label('Duración hasta el momento')
            ->attributes(['disabled' => 'disabled'])
            ->wrapper([
                'class'      => 'form-group col-md-6'
             ]);
        CRUD::field('descripcion')
            ->type('text')
            ->label('Descripción del trabajo realizado')
            ->hint('Por ejemplo: proyecto, issue...');
    }

    /**
     * Permitir acceso a actualización si:
     * - no hay fecha final (no finalizada todavía)
     * - es el propietario o admin
     */
    protected function edit($id)
    {
        $jornada = $this->crud->getEntry($id);
        if (is_null($jornada->final) && (backpack_user()->id == $jornada->user_id)) {
            $this->crud->allowAccess('update');
        } else {
            $this->crud->denyAccess('update');
        }
        return $this->editTrait($id);
    }

    protected function update()
    {
        $jornada = $this->crud->getEntry($this->crud->getRequest()->request->get('id'));
        if (is_null($jornada->final) && (backpack_user()->id == $jornada->user_id)) {
            $this->crud->allowAccess('update');
        } else {
            $this->crud->denyAccess('update');
        }
        return $this->updateTrait();
    }
}
