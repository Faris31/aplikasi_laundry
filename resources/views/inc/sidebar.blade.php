 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard.index') }}" class="brand-link">
         <img src="{{asset('assets/dist/img/logoAU.png')}}" alt="" class="brand-image img-circle" style="">
         <span class="brand-text font-weight-light"><b>Laundry</b>Faris</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- SidebarSearch Form -->
         <div class="form-inline mt-2">
             <div class="input-group" data-widget="sidebar-search">
                 <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                     aria-label="Search">
                 <div class="input-group-append">
                     <button class="btn btn-sidebar">
                         <i class="fas fa-search fa-fw"></i>
                     </button>
                 </div>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 @if (auth()->user()->id_level == 1)
                 <li class="nav-item">
                     <a href="{{ route('user.index') }}" class="nav-link">
                         <i class="fas fa-users nav-icon"></i>
                         <p>User</p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{route('service.index')}}" class="nav-link">
                         <i class="far fa-file-alt mr-1 nav-icon"></i>
                         <p>Jenis Pelayanan</p>
                     </a>
                 </li>
                 @endif
                 @if (auth()->user()->id_level == 2 || auth()->user()->id_level == 1)
                 <li class="nav-item">
                     <a href="{{ route('pelanggan.index') }}" class="nav-link">
                         <i class="fas fa-user nav-icon"></i>
                         <p>Pelanggan</p>
                     </a>
                 </li>
                 @endif
                 @if (auth()->user()->id_level == 2)
                 <li class="nav-item">
                     <a href="{{ route('transaksi.index') }}" class="nav-link">
                         <i class="fas fa-shopping-cart nav-icon"></i>
                         <p>Transaksi</p>
                     </a>
                 </li>
                 @endif

                 @if (auth()->user()->id_level == 3)
                 <li class="nav-item">
                     <a href="{{ route('report.index') }}" class="nav-link">
                         <i class="fas fa-shopping-cart nav-icon"></i>
                         <p>Laporan</p>
                     </a>
                 </li>
                 @endif
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
