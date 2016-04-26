    <div class="container">
         <div class="row ">
                <div class="col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading"><h1 class="h4">Admin Login</h1></div>
                        <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/mt/Login/login">
                            <fieldset>
                            <div class="form-group">
                              <label class="col-xs-4 control-label" for="brugernavn">Brugernavn</label>  
                              <div class="col-xs-8 col-sm-6">
                                <input id="brugernavn" name="brugernavn" type="text" placeholder="brugernavn" class="form-control input-md">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-xs-4 control-label" for="kodeord">Password</label>
                              <div class="col-xs-8 col-sm-6">
                                <input id="kodeord" name="kodeord" type="password" placeholder="kodeord" class="form-control input-md">                             
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="col-xs-12">
                                <button id="login" type="submit" name="login" class="btn btn-primary pull-right">Login</button>
                              </div>
                            </div>
                            </fieldset>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
  	</div>