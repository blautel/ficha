<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\JornadaRequest;
use App\Http\Requests\CreateJornadaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Jornada;

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
        if (backpack_user()->hasRole('administrador')) {
            CRUD::addColumn([
                'name'          => 'User', // name of relationship method in the model
                'type'          => 'relationship',
                'label'         => 'Nombre', // Table column heading
                'searchLogic'   => function ($query, $column, $searchTerm) {
                    $query->orWhereHas('user', function ($q) use ($column, $searchTerm) {
                        $q->where('name', 'like', '%'.$searchTerm.'%');
                    });
                }
            ]);
        }
        CRUD::column('created_at')->type('datetime')->label('Hora inicio');
        CRUD::column('final')->type('datetime')->label('Final');
        CRUD::addColumn([
            'name'      => 'duracion',
            'type'      => 'text',
            'label'     => 'Duración',
            'wrapper'   => [
                'element'   => 'span',
                'id'        => function ($crud, $column, $entry) {
                    return 'dur-id-'.$entry->id;
                },
                'class'     => function ($crud, $column, $entry) {
                    return $entry->final ? '' : 'text-success';
                },
            ],
            'prefix'    => function ($crud, $column, $entry) {
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

        // eliminar acceso a delete
        $this->crud->denyAccess('delete');

        // comprobar si hay alguna jornada en marcha para deny 'create'
        if (Jornada::where('user_id', backpack_user()->id)->whereNull('final')->first()) {
            $this->crud->denyAccess('create');
        }
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
        CRUD::addField([
            'label'     => "Proyecto",
            'placeholder'=> 'Seleccione un proyecto',
            'type'      => "select2",
            'name'      => 'proyecto', // the method on your model that defines the relationship
            'entity'    => 'proyecto',
            'attribute' => 'nombre',
        ]);
        CRUD::addField([
            'label'                 => "Tarea",
            'placeholder'           => 'Seleccione una tarea',
            'type'                  => "select2_from_ajax",
            'name'                  => 'tarea_id', // the column that contains the ID of that connected entity;
            'entity'                => 'tarea', // the method that defines the relationship in your Model
            'attribute'             => 'nombre', // foreign key attribute that is shown to user
            'data_source'           => url('api/tarea'), // url to controller search function (with /{id} should return model)
            'minimum_input_length'  => 0, // minimum characters to type before querying results
            'dependencies'          => ['proyecto'], // when a dependency changes, this select2 is reset to null
            'include_all_form_fields' => true,
        ]);
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
