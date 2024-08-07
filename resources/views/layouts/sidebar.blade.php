<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('img/UIDT.png') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> UFR SET - AGET</a>
            </div>
        </div>
        
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" style="background-color: #005564;">
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Page d'accueil</span>
                </a>
            </li>

            @if (auth()->user()->level == 1)
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cube"></i> <span>SUPERS MAÎTRES</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('batiment.index') }}"><i class="fa fa-circle-o"></i> Batiment</a></li>
                    <li><a href="{{ route('departement.index') }}"><i class="fa fa-circle-o"></i> Département</a></li>
                    <li><a href="{{ route('salle.index') }}"><i class="fa fa-circle-o"></i> Salle</a></li>
                    <li><a href="{{ route('professeur.index') }}"><i class="fa fa-circle-o"></i> Professeur</a></li>
                    <li><a href="{{ route('supplier.index') }}"><i class="fa fa-circle-o"></i> Cours</a></li>
                    <li><a href="{{ route('pengeluaran.index') }}"><i class="fa fa-circle-o"></i> EmploiDuTemps</a></li>
                </ul>
            </li>
            
            <li class="header">RAPPORT</li>
            <li>
                <a href="{{ route('laporan.index') }}">
                    <i class="fa fa-file-pdf-o"></i> <span>Rapport</span>
                </a>
            </li>
            <li class="header">SYSTEM</li>
            <li>
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-users"></i> <span>Utilisateur</span>
                </a>
            </li>
            <li>
                <a href="{{ route('setting.index') }}">
                    <i class="fa fa-cogs"></i> <span>Paramètres</span>
                </a>
            </li>
            @else
            <li>
                <a href="{{ route('transaksi.baru') }}">
                    <i class="fa fa-cart-plus"></i> <span>Nouvelle Transaction</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.index') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaction active</span>
                </a>
            </li>
            @endif 
        </ul>
    </section>
    <!-- /.sidebar -->
</aside><!-- visit "codeastro" for more projects! -->
