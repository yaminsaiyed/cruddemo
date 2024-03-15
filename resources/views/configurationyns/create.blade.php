@extends('layouts.admin_main')

@section('content')

<section class="content">

 @include('flash_messages.admin_message')
<!-- SELECT2 EXAMPLE -->

   {!! Form::open(['method'=>'POST','route'=>['config.store'],'role'=>'form']) !!} 

      <div class="box box-default">
        <div class="box-header with-border">
         <h3 class="box-title"> Create </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            
            <div class="col-md-3">
                <div class="form-group">
                  <label>Model Name </label>
                  {!! Form::text('model',null,['class'=>'form-control model_name','placeholder'=>'Model Name'])!!}
                       
                </div>
            </div>

             <div class="col-md-3">
                <div class="form-group">
                  <label>Controller Name Without <i>"Controller"</i></label>
                  {!! Form::text('controller',null,['class'=>'form-control controller_name','placeholder'=>'Controller Name'])!!}
                       
                </div>
            </div>

             <div class="col-md-3">
                <div class="form-group">
                  <label>Table Name</label>
                  {!! Form::text('table',null,['class'=>'form-control table_name','placeholder'=>'Table Name'])!!}
                       
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                  <label>Create Only Model</label>
                  {{Form::select('only_model', array(0=>"NO",1=>"YES"), '', ['class' => 'form-control select2 filter-select filter_status','style'=>'width: 100%'])}}
                       
                </div>
            </div>

             <div class="clearfix"></div>

                  
              <div class="col-md-3">
                <div class="form-group">
                  <label>Label Name</label>
                  {!! Form::text('label_name',null,['class'=>'form-control label_name','placeholder'=>'Label Name'])!!}
                       
                </div>
            </div>
             
            <div class="col-md-3">
              <div class="form-group">
                <label>Export</label>

              {{Form::select('export', array(1=>"Yes",0=>"No"), '', ['class' => 'form-control select2 filter-select filter_status','style'=>'width: 100%'])}}
              
              </div>
            
            </div>

            <div class="col-md-3">
              <div class="form-group">
                <label>Import</label>

              {{Form::select('import', array(1=>"Yes",0=>"No"), '', ['class' => 'form-control select2 filter-select filter_status','style'=>'width: 100%'])}}
              
              </div>
            
            </div>

             

             <div class="clearfix"></div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Has Many Comma Seperated </label>
                  {!! Form::text('has_many',null,['class'=>'form-control','placeholder'=>'Has Many'])!!}
                       
                </div>
            </div>

             <div class="col-md-6">
                <div class="form-group">
                  <label>Has One Comma Seperated </label>
                  {!! Form::text('has_one',null,['class'=>'form-control','placeholder'=>'Has One'])!!}
                       
                </div>
            </div>

             

             <div class="clearfix"></div>


            
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-default">Reset</button>
        </div>

        
      </div>

      {!! Form::close() !!}


      <!-- /.box -->
      
</section>
    <!-- /.content -->


<script type="text/javascript">
  
  $(".model_name").keyup(function(){
    $(".controller_name").val($(".model_name").val());
    $(".label_name").val($(".model_name").val());
    $(".table_name").val($(".model_name").val().toLowerCase());
});

</script>
@endsection    


