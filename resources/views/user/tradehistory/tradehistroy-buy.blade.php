<div class="pagecontent">
  <div class="container-fluid site-container">
    <div class="bannerpage mt-20">
      <section class="">
        <div class="site-theme-form">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 site-size">
              <div class="banner-border">
                <div class="pull-right">
                  <!-- <button id="show" class="btn btn-gray site-btn mt-20 m-btn text-uppercase nova-font-bold">Search History</button> -->
                  <!-- <button id="hide" class="btn btn-gray site-btn mt-20 text-uppercase m-btn  nova-font-bold none">Close Search</button> -->
                  <select class="btn btn-gray site-btn mt-20 m-btn text-uppercase nova-font-bold" id="pairbuy" name="pair" style="margin-top: 0px;">
                    <option value="all">All pair</option>
                    @foreach($pair_lists as $pairs)
                      <option value="{{ $pairs->id }}">{{ $pairs->coinone}} / {{$pairs->cointwo }}</option>
                    @endforeach
                  </select>
                </div>
                <!--   <div class="search-tab none">
                  <div class="flex-cont pad-10">
                    <form class="form-horizontal site-form normal-form" action="" method="post" id="reg_form">
                      <div class="row form-group">
                        <div class="col-md-4">
                          <div class="form-group has-feedback">
                            <label class="col-xs-12 control-label">Start Date</label>
                            <div class="col-xs-12 inputGroupContainer mui-textfield input-group sgroup">
                              <input type="text" class="form-control" name="st-date">
                              <span class="input-group-btn">
                              <button type="button" class="btn btn-default stbtn" data-toggle="datepicker1" data-target-name="st-date"><span class="glyphicon glyphicon-calendar"></span> </button>
                              </span> </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="has-feedback">
                            <label class="col-xs-12 control-label">End Date</label>
                            <div class="col-xs-12 inputGroupContainer mui-textfield input-group sgroup">
                              <input type="text" class="form-control" name="st-date">
                              <span class="input-group-btn">
                              <button type="button" class="btn btn-default stbtn" data-toggle="datepicker1" data-target-name="st-date"><span class="glyphicon glyphicon-calendar"></span> </button>
                              </span> </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div align="center" class="left-btn">
                            <button type="submit" class="btn btn-gray site-btn mt-20 text-uppercase nova-font-bold m-btn " style="margin:0px;">Submit</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div> -->
                <div class="panel panel-content panel-default panel-border">
                  <div class="panel-body pt-0">
                    <div class="testDiv4">
                      <div class="table-responsive table" id="trade_history_buy"></div>
                    </div>                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script>
  $("body").addClass("trade");
  $(document).ready(function() {
    trade_search()
  });
  $('#pairbuy').on('change', function(event){
    trade_search()
  });
  function trade_search(){
    $.ajax({
      url: '{{ url("/admin/buytrade_his_search") }}',
      type: 'POST',
      data: {
        "_token": "{{ csrf_token() }}",
        "pair": $('#pairbuy').val(),
        "uid": "{{ $uid }}"
      }, 
      success: function (data) {
        $('#trade_history_buy').html(data); 
      },
    }); 
  };
</script>
<script>
  $('[data-toggle=datepicker1]').each(function() {
    var target = $(this).data('target-name');
    var t = $('input[name=' + target + ']');
    t.datepicker({
      format: 'dd-mm-yyyy',
      endDate: '-18y',
      autoclose: true
    });
    $(this).on("click", function() {
      t.datepicker("show");
    });
  });
</script>