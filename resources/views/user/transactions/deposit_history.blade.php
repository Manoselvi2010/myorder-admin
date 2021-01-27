<div class="pagecontent">
  <div class="container-fluid site-container">
    <div class="bannerpage mt-20">
      <section class="">
        <div class="site-theme-form">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 site-size">
              <div class="banner-border">
                <div class="col-md-12 label-search">
                  <form class="form-horizontal site-form normal-form top-search-form" action="" method="post" id="reg_form">
                    <div class="row">
                      <!--  <div class="col-md-2">
                        <div class="form-group  has-feedback">
                          <label class="col-xs-12 control-label">From Date</label>
                          <div class="col-xs-12 inputGroupContainer mui-textfield input-group sgroup">
                            <input type="text" class="form-control" name="st-date" id="from_date">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default stbtn" data-toggle="datepicker3" data-target-name="st-date"><span class="fa fa-calendar"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div> -->
                      <!-- <div class="col-md-2">
                        <div class="form-group  has-feedback">
                          <label class="col-xs-12 control-label">To Date</label>
                          <div class="col-xs-12 inputGroupContainer mui-textfield input-group sgroup">
                            <input type="text" class="form-control" name="st-date" id="to_date">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default stbtn" data-toggle="datepicker3" data-target-name="st-date"><span class="fa fa-calendar"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div> -->
                      <div class="col-md-2">
                        <div class="form-group  has-feedback">
                          <label class="col-xs-12 control-label">Type</label>
                          <div class="col-xs-12 inputGroupContainer mui-textfield input-group sgroup">
                            <select class="form-control" id="type">
                              <option value="received">Deposit</option>
                              <option value="send">Withdraw</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="form-group  has-feedback">
                          <label class="col-xs-12 control-label">Coin / Currency</label>
                          <div class="col-xs-12 inputGroupContainer mui-textfield input-group sgroup">
                            <select class="form-control" id="pairs">
                            @foreach($coins as $pair)
                              <option value="{{ $pair->source }}">{{ $pair->source }}</option>
                            @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group  has-feedback">
                          <label class="col-xs-12 control-label">Status</label>
                          <div class="col-xs-12 inputGroupContainer mui-textfield input-group sgroup">
                            <select class="form-control" id="status">
                              <option value="All">All</option>
                              <option value="1">Pending</option>
                              <option value="2">Completed</option>
                              <option value="3">Cancelled</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="panel panel-content panel-default panel-border">
                  <div class="panel-body pt-0">
                    <div class="pb-40">
                      <div class="testDiv4">
                        <div class="table-responsive table dark" id="history">
                        </div>
                      </div>
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
<script type="text/javascript">
  $(document).ready(function() {
    history_search()
  });
  $('#from_date,#to_date,#pairs,#status').on('changedate', function(event){
    history_search()
  });
  $('#from_date,#to_date,#pairs,#status,#type').on('change', function(event){
    history_search()
  });
  function history_search(){
    $.ajax({
      url: '{{ url("/admin/coin_his_search") }}',
      type: 'POST',
      data: {
        "_token": "{{ csrf_token() }}",
        "fromdate": $('#from_date').val(),
        "todate": $('#to_date').val(),
        "type": $('#type').val(),
        "pair": $('#pairs').val(),
        "status": $('#status').val(),
        "uid": "{{ $uid }}"
      }, 
      success: function (data) {
        $('#history').html(data); 
      },
    }); 
  };
</script>
<script type="text/javascript">
  $(function() {
    $('body').on('click', '.pagination a', function(e) {
      e.preventDefault();
      $('#load a').css('color', '#dfecf6');
      $('#load').append('loding');
      var url = $(this).attr('href');  
      getArticles(url);
      window.history.pushState("", "", url);
    });
    function getArticles(url) {
      $.ajax({
        url: url,
        type: 'POST',
        data: {
          "_token": "{{ csrf_token() }}",
          "fromdate": $('#from_date').val(),
          "todate": $('#to_date').val(),
          "type": $('#type').val(),
          "pair": $('#pairs').val(),
          "status": $('#status').val(),
          "url": url
        }, 
        success: function (data) {
          $('#history').html(data); 
        },
      }); 
    }
  });
</script>
<script>
  $('[data-toggle=datepicker3]').each(function() {
    var target = $(this).data('target-name');
    var t = $('input[name=' + target + ']');
    t.datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });
    $(this).on("click", function() {
      t.datepicker("show");
    });
  });
</script>