@extends('layouts.app')

@section('content')
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- registered total -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Units</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">0 <?php // echo  $total_registered; ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-4x fa-users"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- paymentr completed -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total News </div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"> 0<?php // echo $payment_completed ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-4x fa-credit-card"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- paymentr verified -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Doctors</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">0 <?php // echo $verified; ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-4x fa-check"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
     
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Footfall</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">0 <?php // echo $rejected; ?></div>
            </div>
            <div class="col-auto">
              <i class="fa fa-4x fa-close"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


  {{-- Page Heading  --}}
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">View Units </h1>
    <p class=" text-info">
      <button class="btn btn-primary" align="center" type="button" onclick="printdiv()"><i class="fa fa-print"></i></button>
      <button class="btn btn-warning" onclick="fnExcelReport();" type="button" id="btnExport"><i class="fa fa-file-excel-o"> Export to excel</i></button>

    </p>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card-body">
        <div class="table-responsive">
          <div id="printit">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr class="text-white bg-info">
                  <th class="text-center">#</th>
                  <th class="text-center">Prefix</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Institution name</th>
                  <th class="text-center">Institution Address</th>
                  <th class="text-center">Email Id</th>
                  <th class="text-center">Whatsapp No</th>
                  <th class="text-center">Proof of payment</th>
                  <th class="text-center">Approve</th>
                  <th class="text-center">Reject</th>
                  <th class="text-center">Delete</th> 
                </tr>
              </thead>
              <tbody>
                <?php
              //   $N = new master();
              //   $r = $N->fetch_Verification_Pendings();
              //   for ($i = 0; $i < sizeof($r); $i++) {
              //     $j = $i+1;
              //     echo '<tr>';
              //     echo '<td>' . $j . '</td>';
              //     echo '<td>' . $r[$i]['prefix'] . '</td>';
              //     echo '<td>' . $r[$i]['name'] . '</td>';
              //     echo '<td>' . $r[$i]['iname'] . '</td>';
              //     echo '<td>' . $r[$i]['iadd'] . '</td>';
              //     echo '<td>' . $r[$i]['email'] . '</td>';
              //     echo '<td>' . $r[$i]['wp'] . '</td>';
              //     echo '<td><a href="uploads/payment/' . $r[$i]['img'] . '"  target="_blank"><img src="uploads/payment/' . $r[$i]['img'] . '" alt="' . $r[$i]['img'] . '" style="width:100px;" /></a></td>';
              //     echo '<td><a href="Approve_payment.php?id='.$r[$i]['id'] .'"><i class="fa fa-check" aria-hidden="true"></i></a></td>';
              //     echo '<td><a href="Reject_payment.php?id='.$r[$i]['id'] .'"><i class="fa fa-close" aria-hidden="true"></i></a></td>';
              //     echo '</tr>';
              //   }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection