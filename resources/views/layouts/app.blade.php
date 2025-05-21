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

  {{-- Tiny Mce Instance --}}
  <script src="https://cdn.tiny.cloud/1/r28tlbre711jriqy88bbav1vbfldt3m4nuoprp1gyn9gw281/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
      plugins: [
        // Core editing features
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
        // Your account includes a free trial of TinyMCE premium features
        // Try the most popular premium features until May 9, 2025:
        // 'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf'
      ],
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
      ],
      ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    });
  </script>

</head>

<body id="page-top">

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
    
        @if(Auth::user()->role === 9)
        <li class="nav-item">
          <a class="nav-link" href="{{ route('hospitals.index') }}">
              <i class="fa fa-pencil-square-o"></i>
              <span>Hospitals</span>
          </a>
        </li>
        @endif
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('enquiries.index') }}">
              <i class="fa fa-pencil-square-o"></i>
              <span>Enquiries</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('footfall.index') }}">
              {{-- <i class="fa fa-pencil-square-o"></i> --}}
              <i class="fas fa-shoe-prints"></i>
              <span>Footfall</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('facilities.index') }}">
              {{-- <i class="fa fa-pencil-square-o"></i> --}}
              {{-- <i class="fas fa-shoe-prints"></i> --}}
              <i class="fas fa-bed" aria-hidden="true"></i>
              <span>Facilities</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('partners.index') }}">
              {{-- <i class="fa fa-pencil-square-o"></i> --}}
              {{-- <i class="fas fa-shoe-prints"></i> --}}
              <i class="fas fa-handshake" aria-hidden="true"></i>
              <span>Partners</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('news_and_events.index') }}">
              <i class="fas fa-globe" aria-hidden="true"></i>
              <span>News & Events</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('updates.index') }}">
              <i class="fas fa-bell" aria-hidden="true"></i>
              <span>Updates</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('about_sections.index') }}">
              <i class="fas fa-info" aria-hidden="true"></i>
              <span>&nbsp; About Section</span>
          </a>
        </li>


        <li class="nav-item">
          <a class="nav-link" href="{{ route('doctors.index') }}">
              <i class="fas fa-hospital-user"></i>
              <span>Doctors</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('slides.index') }}">
              <i class="fas fa-images"></i>
              <span>Slides</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('videos.index') }}">
              <i class="fas fa-video"></i>
              <span>Videos</span>
          </a>
        </li>

        
       
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
		      <a class="dropdown-item" href="{{ route('password.request') }}">
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
  

@if (session('success'))
  <div class="alert alert-success alert-dismissible fade show container mt-3" role="alert" style="position: fixed;z-index: 999;top: 0;right: 0;max-width: 400px;">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif

@if (session('error'))
  <div class="alert alert-danger alert-dismissible fade show container mt-3" role="alert" style="position: fixed;z-index: 999;top: 0;right: 0;max-width: 400px;">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif


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
    setTimeout(function () {
        if ($('.alert').length) {
            $('.alert').fadeOut('slow');
        }
    }, 3000); // adjust time as needed
</script>

@yield('scripts')

</body>

</html>