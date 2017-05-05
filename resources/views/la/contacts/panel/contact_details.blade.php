<div class="panel panel-default">
  <div class="panel-heading">Dynamic Form Fields - Add & Remove Multiple fields</div>
  <div class="panel-heading">Education Experience</div>
  <div class="panel-body">

  <div id="education_fields">

        </div>
       <div class="col-sm-3 nopadding">
  <div class="form-group">
    <input type="text" class="form-control" id="Schoolname" name="Schoolname[Schoolname]" value="" placeholder="School name">
  </div>
</div>
<div class="col-sm-3 nopadding">
  <div class="form-group">
    <input type="text" class="form-control" id="Major" name="Schoolname[Major]" value="" placeholder="Major">
  </div>
</div>
<div class="col-sm-3 nopadding">
  <div class="form-group">
    <input type="text" class="form-control" id="Degree" name="Schoolname[Degree]" value="" placeholder="Degree">
  </div>
</div>

<div class="col-sm-3 nopadding">
  <div class="form-group">
    <div class="input-group">
      <select class="form-control" id="educationDate" name="Schoolname[educationDate]">

        <option value="">Date</option>
        <option value="2015">2015</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
      </select>
      <div class="input-group-btn">
        <button class="btn btn-success" type="button"  onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>

  </div>
  <div class="panel-footer"><small>Press <span class="glyphicon glyphicon-plus gs"></span> to add another form field :)</small>, <small>Press <span class="glyphicon glyphicon-minus gs"></span> to remove form field :)</small></div>
  <div class="panel-footer"><small><em><a href="http://shafi.info/">More Info - Developer Shafi (Bangladesh)</a></em></em></small></div>
</div>

@push('scripts')
    <script type="text/javascript">
    var room = 1;
    function education_fields() {

        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
    	divtest.setAttribute("class", "form-group removeclass"+room);
    	var rdiv = 'removeclass'+room;
        divtest.innerHTML = '<div class="col-sm-3 nopadding"><div class="form-group"><input type="text" class="form-control" id="Schoolname" name="Schoolname[Schoolname]" value="" placeholder="School name"></div></div><div class="col-sm-3 nopadding"><div class="form-group"><input type="text" class="form-control" id="Major" name="Schoolname[Major]" value="" placeholder="Major"></div></div><div class="col-sm-3 nopadding"><div class="form-group">
     <input type="text" class="form-control" id="Degree" name="Schoolname[Degree]" value="" placeholder="Degree"></div></div><div class="col-sm-3 nopadding"><div class="form-group">    <div class="input-group">       <select class="form-control" id="educationDate" name="Schoolname[educationDate]">
         <option value="">Date</option>         <option value="2015">2015</option> <option value="2016">2016</option> <option value="2017">2017</option>
         <option value="2018">2018</option>       </select>       <div class="input-group-btn">         <button class="btn btn-success" type="button"  onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>       </div>     </div>   </div> </div> <div class="clear"></div>';

        objTo.appendChild(divtest)
    }
       function remove_education_fields(rid) {
    	   $('.removeclass'+rid).remove();
       }
    </script>
@endpush
