  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <img src="{{ asset('assets') }}/adminLte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('assets') }}/adminLte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/home" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Users <i class="right fas fa-angle-left"></i> </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="/admin" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Admin</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/user" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Member</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>Event <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/transportasi" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Transportasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/kategori" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Kategroi Event</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/destinasi" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Destinasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/event" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Event</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="/galery" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Galery</p>
                    </a>
                </li> --}}
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>Transaksi <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/transaksi" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Transaksi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/alamat-pembayaran" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Alamat Pembayaran</p>
                    </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tags"></i>
                  <p>Ulasan <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/ulasan" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ulasan</p>
                    </a>
                </li>
              </ul>
            </li>

            {{-- Logout --}}
            <li class="nav-item">
                <a class="nav-link bg-danger"  href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>{{ __('Logout') }}</p>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>