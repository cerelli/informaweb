{{ HTML::style('css/informaweb.css') }}
<script>
/* __________________ RESPONSIVE EQUAL HEIGHTS  __________________*/
/*! jquery.matchHeight-min.js v0.5.1  |  http://brm.io/jquery-match-height/  |  License: MIT  */

(function(a){a.fn.matchHeight=function(b){if("remove"===b){var f=this;this.css("height","");a.each(a.fn.matchHeight._groups,function(g,h){h.elements=h.elements.not(f)});return this}if(1>=this.length){return this}b="undefined"!==typeof b?b:!0;a.fn.matchHeight._groups.push({elements:this,byRow:b});a.fn.matchHeight._apply(this,b);return this};a.fn.matchHeight._apply=function(b,g){var h=a(b),f=[h];g&&(h.css({display:"block","padding-top":"0","padding-bottom":"0","border-top":"0","border-bottom":"0",height:"100px"}),f=c(h),h.css({display:"","padding-top":"","padding-bottom":"","border-top":"","border-bottom":"",height:""}));a.each(f,function(i,l){var k=a(l),j=0;k.each(function(){var m=a(this);m.css({display:"block",height:""});m.outerHeight(!1)>j&&(j=m.outerHeight(!1));m.css({display:""})});k.each(function(){var m=a(this),n=0;"border-box"!==m.css("box-sizing")&&(n+=e(m.css("border-top-width"))+e(m.css("border-bottom-width")),n+=e(m.css("padding-top"))+e(m.css("padding-bottom")));m.css("height",j-n)})});return this};a.fn.matchHeight._applyDataApi=function(){var b={};a("[data-match-height], [data-mh]").each(function(){var f=a(this),g=f.attr("data-match-height");b[g]=g in b?b[g].add(f):f});a.each(b,function(){this.matchHeight(!0)})};a.fn.matchHeight._groups=[];var d=-1;a.fn.matchHeight._update=function(b){if(b&&"resize"===b.type){b=a(window).width();if(b===d){return}d=b}a.each(a.fn.matchHeight._groups,function(){a.fn.matchHeight._apply(this.elements,this.byRow)})};a(a.fn.matchHeight._applyDataApi);a(window).bind("load resize orientationchange",a.fn.matchHeight._update);var c=function(b){var f=null,g=[];a(b).each(function(){var i=a(this),k=i.offset().top-e(i.css("margin-top")),j=0<g.length?g[g.length-1]:null;null===j?g.push(i):1>=Math.floor(Math.abs(f-k))?g[g.length-1]=j.add(i):g.push(i);f=k});return g},e=function(b){return parseFloat(b)||0}})(jQuery);


$(document).ready(function() {
    $('.equal-height-panels .panel').matchHeight();
    });
</script>

<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-contacts">
    <div class="tab-content">
        <div class="panel infolist">
            <div class="panel-default panel-heading">
                <h4>Contacts
                    @la_access("Contacts", "create")
                        <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">{{ __('Add Contact') }}</button>
                    @endla_access
                </h4>
            </div>
            {{-- <div class="container"> --}}
                <div class="row equal-height-panels">
                        <div class="alert alert-warning empty-grid hidden">
                            There are no records to display
                        </div>
                        @foreach ($account->contacts as $contact)
                            <div class="col-sm-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                    <div class="col-xs-3 col-sm-6">
                                        <h3 class="panel-title">
                                            @la_displayField($contact, 'first_name', 'Contacts')
                                            @la_displayField($contact, 'last_name', 'Contacts')
                                        </h3>
                                    </div>
                                    <div class="col-xs-3 col-sm-6">
                                        <a href="#" class="pull-right btn btn-xs btn-danger btn-hidden" ><i class="fa fa-times" aria-hidden="true"></i></a>
                                        <a href="' . url(config('laraadmin.adminRoute') . '/accounts/' . $data->data[$i][0] . '/edit') . '" class="pull-right btn btn-xs btn-warning btn-hidden"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                    </div>
                                    </div>
                                    <div class="panel-body">
                                        @foreach ($contact->contact_details as $contact_detail)
                                            <div class="dats1">
                                                <i class="fa {{$contact_detail->communication_type->fa_icon}}"></i>
                                                @la_displayField($contact_detail, 'value', 'Contact_details')
                                                <a href="#" class="pull-right btn btn-xs btn-danger btn-hidden"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                <a href="#" class="pull-right btn btn-xs btn-warning btn-hidden"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        @endforeach

                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>

@include('la.accounts.modal.contact_create')
@include('la.accounts.modal.contact_edit')
