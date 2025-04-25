<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>ACCF Webmaster</title>
  <!-- Custom fonts for this template-->
  <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{ asset('mrincustom.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- DataTables core CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

  <!-- Buttons plugin CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

  <!-- Optional: DataTables responsive CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

</head>

<body id="page-top">

  {{-- @foreach (['success', 'danger', 'warning', 'info'] as $type)
    @if(session($type))
        <div aria-live="polite" aria-atomic="true" style="position: fixed; bottom: 1rem; right: 1rem; z-index: 1080;">
            <div class="toast bg-{{ $type }} text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" data-autohide="true">
                <div class="toast-header bg-{{ $type }} text-white">
                    <strong class="mr-auto text-white text-capitalize"><h4>{{ $type }}</h4></strong>
                    <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                  <h6>{{ session($type) }}</h6>
                </div>
            </div>
        </div>
    @endif
  @endforeach --}}

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
    
        <div class="sidebar-brand-icon">
    
        </div>
        <div class="sidebar-brand-text mx-3" style="text-transform:uppercase">ACCF Webmaster</div>
        </a>
        <p class="text-center text-white">{{ Auth::user()->role == 9 ? 'SuperAdmin' : 'Admin'}} Panel</p>
    
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
    
        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
        <a class="nav-link" href="/home">
            <i class="fa fa-fw fa-home"></i>
            <span>Home</span></a>
        </li>
    
        <hr class="sidebar-divider">
    
        <li class="nav-item">
        <a class="nav-link" href="{{ route('hospitals.index') }}">
            <i class="fa fa-pencil-square-o"></i>
            <span>Hospitals</span>
        </a>
        </li>
        
        <li class="nav-item">
        <a class="nav-link" href="Enquiries.php">
            <i class="fa fa-pencil-square-o"></i>
            <span>Enquiries</span>
        </a>
        </li>

        <!-- Nav Item - Menu with Submenu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="true" aria-controls="collapseOne">
                <i class="fas fa-fw fa-cog"></i>
                <span>Settings</span>
            </a>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="#">Profile</a>
                    <a class="collapse-item" href="#">Change Password</a>

                    <!-- Nested Submenu -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse" data-target="#collapseNested"
                        aria-expanded="false" aria-controls="collapseNested">
                        Advanced
                    </a>
                    <div id="collapseNested" class="collapse ml-3" data-parent="#collapseOne">
                        <a class="collapse-item" href="#">Logs</a>
                        <a class="collapse-item" href="#">Permissions</a>
                    </div>
                </div>
            </div>
        </li>
    
        <!-- Nav Item - Charts -->
        <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fa fa-sign-out fa-fw"></i>
            <span>Logout</span></a>
        </li>
    
    
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

		<!-- Topbar -->
		<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style="display: flex;flex-direction: row-reverse;">

		  <!-- Sidebar Toggle (Topbar) -->
		  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
		    <i class="fa fa-bars"></i>
		  </button>

		  <!-- Nav Item - User Information -->
		  <li class="nav-item dropdown no-arrow" style="list-style: none;">
		    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		      <span class="mr-2 d-lg-inline text-gray-600 small mrin_user">{{ Auth::user()->name }}</span>
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
		    </a>
		    <!-- Dropdown - User Information -->
		    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
		      <a class="dropdown-item" href="change_password.php">
		        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
		        Change Password
		      </a>
		      <div class="dropdown-divider"></div>
		      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
		        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
		        Logout
		      </a>
		    </div>
		  </li>

		  </ul>

		</nav>
		<!-- End of Topbar -->

        <div style="">

          <!-- Begin Page Content -->
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>

      </div>
    </div>

    <!-- End of Footer -->
  </div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <!-- Modal -->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        
        <div class="modal-body">
          Select "Logout" below if you are ready to end your current session.
        </div>
        
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Logout</button>
          </form>
          
        </div>
  
      </div>
    </div>
  </div>
  

  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js')}}"></script>
  {{-- <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script> --}}
  {{-- <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script> --}}

  <script type="text/javascript">
    function printdiv() {
        var printContents = document.getElementById('printit').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        window.location.reload();
    }

    function fnExcelReport() {
        var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange;
        var j = 0;
        tab = document.getElementById('dataTable'); // id of table

        for (j = 0; j < tab.rows.length; j++) {
        tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
        //tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer
        {
        txtArea1.document.open("txt/html", "replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();
        sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
        } else //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

        return (sa);
    }
  </script>

<script>
  // $(document).ready(function () {
  //     // Show the toast notifications when the page is loaded
  //     $('.toast').toast('show');
  // });
</script>

@yield('scripts')

</body>

</html>