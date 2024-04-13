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
                <a href="#"><i class="fa fa-circle text-success"></i> UFR SES - UFR SET</a>
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
            <li class="header">SUPERS MAÎTRES</li>
            <li>
                <a href="{{ route('batiment.index') }}">
                    <i class="fa fa-cube"></i> <span>Batiment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('departement.index') }}">
                    <i class="fa fa-home"></i> <span>Département</span>
                </a>
            </li>
            <li>
                <a href="{{ route('salle.index') }}">
                    <i class="fa fa-university"></i> <span>Salle</span>
                </a>
            </li>
            <li>
                <a href="{{ route('professeur.index') }}">
                    <i class="fa fa-users"></i> <span>Professeur</span>
                </a>
            </li>
            <li>
                <a href="{{ route('supplier.index') }}">
                    <i class="fa fa-book"></i> <span>Cours</span>
                </a>
            </li>
           
            <li>
                <a href="{{ route('pengeluaran.index') }}">
                    <i class="fa fa-clock-o"></i> <span>EmploiDuTemps</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pembelian.index') }}">
                    <i class="fa fa-download"></i> <span>Achat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-dollarp">F</i> 
                    <span>Liste des ventes</span>
                </a>
            </li>
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
            
            <li class="header">REPORT</li>
            <li>
                <a href="{{ route('laporan.index') }}">
                    <i class="fa fa-file-pdf-o"></i> <span>Revenu</span>
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