webpackJsonp([2,0],{0:function(e,s,a){"use strict";function r(e){return e&&e.__esModule?e:{"default":e}}var t=a(109),n=r(t),o=a(108),i=r(o),l=a(107),f=r(l);n["default"].use(i["default"]),new n["default"]({el:"body",components:{Filter:f["default"]}})},103:function(e,s,a){"use strict";function r(e){return e&&e.__esModule?e:{"default":e}}Object.defineProperty(s,"__esModule",{value:!0});var t=a(1),n=r(t);n["default"].locale("fr"),s["default"]={props:{root:String,auth:Boolean},data:function(){return{apiUrl:this.root+"/api/reservations",loading:!1,validation:!0,form:{name:"",forename:""},reservations:{}}},methods:{buildQuery:function(e,s){var a="";for(var r in e)a+="&"+encodeURIComponent(r)+"="+encodeURIComponent(e[r]);return s.indexOf("?")===-1&&(a=a.replace("&","?")),s+a},getReservations:function(e,s){if(e){void 0===s&&(s={}),this.validation&&(s.valid=!0),e=this.buildQuery(s,e),this.loading=!0;var a=this;this.$http.get(e).then(function(e){a.loading=!1,a.reservations=e.json(),a.reservations.page_range=Array(a.reservations.last_page).fill(),a.reservations.data.forEach(function(e,s,a){e.arrive_at=(0,n["default"])(e.arrive_at),e.leave_at=(0,n["default"])(e.leave_at),a[s]=e})},function(e){console.error(e.statusText)})}},clear:function(){this.form.name="",this.form.forename="",this.formSubmit()},formSubmit:function(){var e={};this.form.name&&(e.name__eq=this.form.name),this.form.forename&&(e.forename__eq=this.form.forename),e!=={}&&(console.log(e),this.getReservations(this.apiUrl,e))}},ready:function(){this.getReservations(this.apiUrl)}}},104:function(e,s){},105:function(e,s,a){function r(e){return a(t(e))}function t(e){return n[e]||function(){throw new Error("Cannot find module '"+e+"'.")}()}var n={"./af":2,"./af.js":2,"./ar":6,"./ar-ma":3,"./ar-ma.js":3,"./ar-sa":4,"./ar-sa.js":4,"./ar-tn":5,"./ar-tn.js":5,"./ar.js":6,"./az":7,"./az.js":7,"./be":8,"./be.js":8,"./bg":9,"./bg.js":9,"./bn":10,"./bn.js":10,"./bo":11,"./bo.js":11,"./br":12,"./br.js":12,"./bs":13,"./bs.js":13,"./ca":14,"./ca.js":14,"./cs":15,"./cs.js":15,"./cv":16,"./cv.js":16,"./cy":17,"./cy.js":17,"./da":18,"./da.js":18,"./de":20,"./de-at":19,"./de-at.js":19,"./de.js":20,"./dv":21,"./dv.js":21,"./el":22,"./el.js":22,"./en-au":23,"./en-au.js":23,"./en-ca":24,"./en-ca.js":24,"./en-gb":25,"./en-gb.js":25,"./en-ie":26,"./en-ie.js":26,"./en-nz":27,"./en-nz.js":27,"./eo":28,"./eo.js":28,"./es":30,"./es-do":29,"./es-do.js":29,"./es.js":30,"./et":31,"./et.js":31,"./eu":32,"./eu.js":32,"./fa":33,"./fa.js":33,"./fi":34,"./fi.js":34,"./fo":35,"./fo.js":35,"./fr":38,"./fr-ca":36,"./fr-ca.js":36,"./fr-ch":37,"./fr-ch.js":37,"./fr.js":38,"./fy":39,"./fy.js":39,"./gd":40,"./gd.js":40,"./gl":41,"./gl.js":41,"./he":42,"./he.js":42,"./hi":43,"./hi.js":43,"./hr":44,"./hr.js":44,"./hu":45,"./hu.js":45,"./hy-am":46,"./hy-am.js":46,"./id":47,"./id.js":47,"./is":48,"./is.js":48,"./it":49,"./it.js":49,"./ja":50,"./ja.js":50,"./jv":51,"./jv.js":51,"./ka":52,"./ka.js":52,"./kk":53,"./kk.js":53,"./km":54,"./km.js":54,"./ko":55,"./ko.js":55,"./ky":56,"./ky.js":56,"./lb":57,"./lb.js":57,"./lo":58,"./lo.js":58,"./lt":59,"./lt.js":59,"./lv":60,"./lv.js":60,"./me":61,"./me.js":61,"./mk":62,"./mk.js":62,"./ml":63,"./ml.js":63,"./mr":64,"./mr.js":64,"./ms":66,"./ms-my":65,"./ms-my.js":65,"./ms.js":66,"./my":67,"./my.js":67,"./nb":68,"./nb.js":68,"./ne":69,"./ne.js":69,"./nl":70,"./nl.js":70,"./nn":71,"./nn.js":71,"./pa-in":72,"./pa-in.js":72,"./pl":73,"./pl.js":73,"./pt":75,"./pt-br":74,"./pt-br.js":74,"./pt.js":75,"./ro":76,"./ro.js":76,"./ru":77,"./ru.js":77,"./se":78,"./se.js":78,"./si":79,"./si.js":79,"./sk":80,"./sk.js":80,"./sl":81,"./sl.js":81,"./sq":82,"./sq.js":82,"./sr":84,"./sr-cyrl":83,"./sr-cyrl.js":83,"./sr.js":84,"./ss":85,"./ss.js":85,"./sv":86,"./sv.js":86,"./sw":87,"./sw.js":87,"./ta":88,"./ta.js":88,"./te":89,"./te.js":89,"./th":90,"./th.js":90,"./tl-ph":91,"./tl-ph.js":91,"./tlh":92,"./tlh.js":92,"./tr":93,"./tr.js":93,"./tzl":94,"./tzl.js":94,"./tzm":96,"./tzm-latn":95,"./tzm-latn.js":95,"./tzm.js":96,"./uk":97,"./uk.js":97,"./uz":98,"./uz.js":98,"./vi":99,"./vi.js":99,"./x-pseudo":100,"./x-pseudo.js":100,"./zh-cn":101,"./zh-cn.js":101,"./zh-tw":102,"./zh-tw.js":102};r.keys=function(){return Object.keys(n)},r.resolve=t,e.exports=r,r.id=105},106:function(e,s){e.exports=' <form> <div class=row> <h3>Filtres</h3> <div class="form-group col-md-6"> <label for=name>Nom</label> <input type=text class=form-control id=name @change=formSubmit() v-model=form.name lazy> </div> <div class="form-group col-md-6"> <label for=forename>Prénom</label> <input type=text class=form-control id=forename @change=formSubmit() v-model=form.forename lazy> </div> </div> <div class=form-group> <button @click.prevent=formSubmit() class="btn btn-default">Chercher</button> <button @click.prevent=clear() class="btn btn-default">Clear</button> </div> </form> <form> <div class=checkbox> <label> <input type=checkbox @change=formSubmit() v-model=validation> Uniquement les réservations validés </label> </div> </form> <div v-show=loading> <p class=text-center> <button class="btn btn-lg btn-info"> <span aria-hidden=true class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading... </button> </p> </div> <div class="panel panel-primary" v-for="reservation in reservations.data" v-show=!loading> <div class=panel-heading> <h1 class=panel-title>{{ reservation.name }} {{ reservation.forename }}</h1> </div> <div class=panel-body> Du <a href="{{ root + \'/calendar/\' + reservation.arrive_at.format(\'Y/M/D\') }}">{{ reservation.arrive_at.format(\'D MMMM Y\') }}</a> au <a href="{{ root + \'/calendar/\' + reservation.leave_at.format(\'Y/M/D\') }}">{{ reservation.leave_at.format(\'D MMMM Y\') }}</a> pour {{ reservation.nb_people }} personne(s). </div> <div class=panel-footer> <a class="btn btn-default" href="{{ this.root }}/reservations/{{ reservation.id }}">Voir la réservation</a> <a v-if=auth class="btn btn-default" href="{{ this.root }}/reservations/{{ reservation.id }}/edit">Modifier la réservation</a> </div> </div> <nav aria-label="Page navigation" class=text-center v-show=!loading> <ul class=pagination> <li :class="[reservations.prev_page_url ? \'\' : \'disabled\']"> <a href=# aria-label=Previous @click.prevent=getReservations(reservations.prev_page_url)> <span aria-hidden=true>&laquo;</span> </a> </li> <li v-for="uv in reservations.page_range" track-by=$index :class="[($index + 1) === reservations.current_page ? \'active\' : \'\']"> <a href=# @click.prevent="getReservations(apiUrl+\'?page=\'+($index + 1))">{{ $index + 1 }}</a> </li> <li :class="[reservations.next_page_url ? \'\' : \'disabled\']"> <a href=# aria-label=Next @click.prevent=getReservations(reservations.next_page_url)> <span aria-hidden=true>&raquo;</span> </a> </li> </ul> </nav> '},107:function(e,s,a){var r,t;a(104),r=a(103),t=a(106),e.exports=r||{},e.exports.__esModule&&(e.exports=e.exports["default"]),t&&(("function"==typeof e.exports?e.exports.options||(e.exports.options={}):e.exports).template=t)}});
//# sourceMappingURL=app.js.map