<!DOCTYPE html>

<html>
<head>
    {!!Html::style('css/app.css')!!}
        {!!Html::style('js/app.js')!!}
</head>
<body>

<h1>My First Heading</h1>
<p>My first paragraph.</p>

<h1>count data {{  count($name) }}</h1>
<button class="btn btn-warning">test</button>
<ul>

        <li>{{$name[$index]}}</li>

        {!! Form::open(['']) !!}
        <div class="row">
                <div class="col-md-3">
                        <div class="form-group">
                                {!! form::label('name','Name') !!}
                                {!! form::text('naqame',null,['id'=>'name','class'=>'form-control']) !!}
                        </div>
                </div>

                <div class="col-md-3">
                        <div class="form-group">
                                {!! form::label('name','Name') !!}
                                {!! form::password('naqame',['id'=>'name_','class'=>'form-control']) !!}
                        </div>
                </div>

        </div>


        {!! Form::close() !!}

</ul>

</body>
</html>