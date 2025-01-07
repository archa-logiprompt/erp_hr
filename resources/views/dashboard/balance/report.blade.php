@extends('layouts.dashboard.app')

@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Monthly Balance Report</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.balance.report') }}" novalidate>
                    @csrf
                    <div class="col-6">
                        <label class="form-label" for="studentSelect">Search Month</label>
                        <input type="month" name="month" value="{{ isset($postdate) ? $postdate : date('Y-m') }}" class="form-control" required>
                            
                        @error('month')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 mt-5">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
                

               
            </div>
        </div>
    </div>  
    @isset($student_payments)
        
    <div class="card">
        <div class="card-body">

        <div class="table-responsive">
            <table id="export-button">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Student Name</th>
                        <th>Total Paid Fee</th>
                        <th>Monthly Installment</th>
                        <th>Total Monthly Installment</th>
                        <th>Balance Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @php   
                        $total_amount_paid = 0; 
                        $balance_fee = 0; 
                    @endphp
                    @foreach ($student_payments as $payment ) 
                        @if((date('Y-m', strtotime($fromdate)) >= date('Y-m', strtotime($payment->admissiondate))  ))
                   
                  
                    <tr class="{{$payment->amount_diff>0?'table-danger':''}}">
                        
                        <td>{{$loop->iteration}}</td>
                        <td>{{$payment->studentname}} ({{$payment->course->coursename}})</td>
                        <td>{{$payment->total_amount_paid}} ₹</td>
                        <td>{{$payment->monthly_installment}} ₹</td>
                        <td>{{$payment->amount_to_be_paid}} ₹</td>
                        <td>{{$payment->amount_diff>0?"$payment->amount_diff ₹":0}}</td>
                    </tr>

                    @php   
                        $total_amount_paid += $payment->total_amount_paid; 
                        $balance_fee += $payment->amount_diff>0?$payment->amount_diff:0; 
                    @endphp

                        @endif
                    @endforeach

                    <tr style="color:green;font-weight:bold;font-size:16px">
                        <td>Total:</td>
                        <td></td>
                        <td>{{$total_amount_paid}} ₹</td>
                        <td></td>
                        <td></td>
                        <td>{{$balance_fee}} ₹</td>
                    </tr>


                </tbody>
            </table>
        </div>
        </div>
    </div>
    @endisset

</div>

@endsection
