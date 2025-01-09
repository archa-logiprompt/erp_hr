<div class="sidebar-wrapper" data-layout="stroke-svg">
    <div class="logo-wrapper d-flex align-items-center justify-content-between">
        <a href="{{ route('admin.dashboard') }}">
            <img class="img-fluid w-50" src="{{ asset('assets/logo/logilogo.jpg') }}" alt="">
        </a>

        <div class="logo-text d-flex flex-column align-items-start">
            <span style="color:lightblue; font-size:20px; font-weight:bold; font-family: Arial, sans-serif;">
                Logiprompt
            </span>
            <span
                style="color:lightblue; font-size:10px;white-space: nowrap; overflow: hidden; text-overflow: ellipsis; ">
                TechnoSolutions India Pvt Ltd
            </span>
        </div>

        <div class="back-btn">
            <i class="fa fa-angle-left"></i>
        </div>
    </div>
    <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a></div>
    <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
            <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                            src="{{ asset('assets/images/logo/logo-icon.png') }}" alt=""></a>
                    <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                            aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                    <div>
                        <h6>Pinned</h6>
                    </div>
                </li>

                <li class="sidebar-main-title">
                    <div>
                        <h6>General </h6>
                    </div>

                </li>


                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="{{ route('admin.dashboard') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                        </svg><span>Dashboard
                        </span></a>
                    <ul class="sidebar-submenu">

                    </ul>
                </li>

                <li class="sidebar-main-title">
                    <div>
                        <h6>Invoice</h6>
                    </div>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="../assets/svg/icon-sprite.svg#stroke-form"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-form"> </use>
                        </svg><span>Invoice</span></a>
                    <ul class="sidebar-submenu">
                        <li> <a class="submenu-title" href="{{ route('admin.generalsettings.index') }}">General settings
                                <span class="sub-arrow"> <i class="fa fa-angle-right"></i></span></a>
                        </li>
                        <li><a href="{{ route('admin.gst.index') }}">Gst</a></li>
                        <li><a href="{{ route('admin.tax.index') }}">Tax Master</a></li>
                        <li><a href="{{ route('admin.fee.index') }}">Fee Master</a></li>
                        <li> <a class="submenu-title" href="{{ route('admin.clientinvoice.index') }}">Client invoice
                                <span class="sub-arrow"> <i class="fa fa-angle-right"></i></span></a>
                        </li>

                    </ul>
                </li>

                <li class="sidebar-main-title">
                    <div>
                        <h6>Development</h6>
                    </div>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="../assets/svg/icon-sprite.svg#stroke-ui-kits"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-ui-kits"></use>
                        </svg><span>Work</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('admin.client.index') }}">Client</a></li>
                        <li><a href="{{ route('admin.project.index') }}">Project</a></li>
                    </ul>
                </li>

                <li class="sidebar-main-title">
                    <div>
                        <h6>Academy </h6>
                    </div>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                        </svg><span>Course</span></a>
                    <ul class="sidebar-submenu">
                        <li> <a href="{{ route('admin.course.index') }}">Course Details</a></li>
                    </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-project') }}"></use>
                        </svg><span>Student
                        </span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('admin.student.index') }}">Student List</a></li>
                    </ul>
                </li>

                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                        </svg><span>Student invoice</span></a>
                    <ul class="sidebar-submenu">
                        <li> <a href="{{ route('admin.studentinvoice.index') }}">Invoice Details</a></li>
                    </ul>
                </li>

                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-project') }}"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-ecommerce"></use>
                        </svg><span>Center</span></a>
                    <ul class="sidebar-submenu">
                        <li> <a href="{{ route('admin.center.index') }}">Center Details</a></li>

                    </ul>
                </li>
                <li class="sidebar-main-title">
                    <div>
                        <h6>Income & Expense
                    </div>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="../assets/svg/icon-sprite.svg#stroke-form"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-form"> </use>
                        </svg><span>Income </span></a>
                    <ul class="sidebar-submenu">

                        <li><a href="{{ route('admin.incomehead.index') }}">Head</a></li>
                        <li><a href="{{ route('admin.incomedetails.index') }}">Details</a></li>


                    </ul>
                </li>

                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="../assets/svg/icon-sprite.svg#stroke-form"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-form"> </use>
                        </svg><span>Expense </span></a>
                    <ul class="sidebar-submenu">

                        <li><a href="{{ route('admin.expensehead.index') }}">Head</a></li>
                        <li><a href="{{ route('admin.expense.index') }}">Details</a></li>


                    </ul>
                </li>
                <li class="sidebar-main-title">
                    <div>
                        <h6>Human Resources
                    </div>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="../assets/svg/icon-sprite.svg#stroke-form"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-form"> </use>
                        </svg><span>Master Entry </span></a>
                    <ul class="sidebar-submenu">

                        <li><a href="{{ route('admin.role.index') }}">Roles</a></li>
                        <li><a href="{{ route('admin.permission.index') }}">Permissions</a></li>


                    </ul>
                </li>
                <li class="sidebar-main-title">
                    <div>
                        <h6>Reports</h6>
                    </div>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title"
                        href="#">
                        <svg class="stroke-icon">
                            <use href="../assets/svg/icon-sprite.svg#stroke-ui-kits"></use>
                        </svg>
                        <svg class="fill-icon">
                            <use href="../assets/svg/icon-sprite.svg#fill-form"></use>
                        </svg><span>All reports</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{ route('admin.gstreport.create') }}">Gst Report</a></li>
                        <li><a href="{{ route('admin.incomeReport.index') }}">Income Report</a></li>
                        <!--<li><a href="{{ route('admin.expenseReport.index') }}">Expense Report</a></li>-->
                        <li><a href="{{ route('admin.expReport.index') }}">Expense Report</a></li>

                        <li><a href="{{ route('admin.clientReport.index') }}">Client</a></li>
                        <li><a href="{{ route('admin.balance.create') }}">Student Balance </a></li>
                        <li><a href="{{ route('admin.balance.report') }}">Monthly Student Balance </a></li>

                    </ul>
                </li>

    </nav>
</div>
