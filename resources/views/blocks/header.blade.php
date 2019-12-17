<!-- BEGIN HEADER -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-collapse collapse">
            <div class="nav navbar-nav navbar-right">
                    <a class="btn btn-primary navbar-btn" href="logout"
                       onclick="event.preventDefault(); document.getElementById('logout-form-navbar').submit();">
                        <span class="glyphicon glyphicon-log-out"></span> Logout</a>
                    <form id="logout-form-navbar" action="{{url('/logout/')}}" method="POST"
                          style="display: none !important;">
                        {{csrf_field()}}
                    </form>
            </div>
        </div>
    </div>
</nav>
<!-- END HEADER -->