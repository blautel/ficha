<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('jornada') }}'><i class='nav-icon la la-hourglass-start'></i> Jornadas</a></li>
@can('gest-accesos')
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('proyecto') }}'><i class='nav-icon la la-project-diagram'></i> Proyectos</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('tarea') }}'><i class='nav-icon la la-tasks'></i> Tareas</a></li>
<li class="nav-item nav-dropdown">
	<a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Acceso</a>
	<ul class="nav-dropdown-items">
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Usuarios</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
	  <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permisos</span></a></li>
	</ul>
</li>
@endcan


