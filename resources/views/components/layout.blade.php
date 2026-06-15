<!DOCTYPE html>
<html lang="pt-BR">

<head>

  <x-header/>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

            <x-side-bar/>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

               <x-navbar/>

                {{$slot}}
                
            </div>
            <!-- End of Main Content -->

          <x-footer/>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <x-modal/>

    <x-script/>
    

</body>

</html>