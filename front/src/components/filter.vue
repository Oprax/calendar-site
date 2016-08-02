<template>
  <form>
    <div class="row">
      <h3>Filtres</h3>
      <div class="form-group col-md-6">
        <label for="name">Nom</label>
        <input type="text" class="form-control" id="name" v-model="form.name" lazy>
      </div>
      <div class="form-group col-md-6">
        <label for="forename">Prénom</label>
        <input type="text" class="form-control" id="forename" v-model="form.forename" lazy>
      </div>
    </div>
    <div class="form-group">
      <button @click.prevent="formSubmit()" class="btn btn-default">Chercher</button>
    </div>
  </form>

  <div v-show="loading">
    <p class="text-center">
      <button class="btn btn-lg btn-info">
        <span aria-hidden="true" class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...
      </button>
    </p>
  </div>

  <div class="panel panel-primary" v-for="reservation in reservations.data" v-show="!loading">
    <div class="panel-heading">
      <h1 class="panel-title">{{ reservation.name }} {{ reservation.forename }}</h1>
    </div>
    <div class="panel-body">
      Du {{ reservation.arrive_at.format('D MMMM Y') }} au {{ reservation.leave_at.format('D MMMM Y') }} pour {{ reservation.nb_people }} personne(s).
    </div>
    <div class="panel-footer">
      <a class="btn btn-default" href="{{ this.root }}/reservations/{{ reservation.id }}">Voir la réservation</a>
      <a class="btn btn-default" href="{{ this.root }}/reservations/{{ reservation.id }}/edit">Modifier la réservation</a>
    </div>
  </div>

  <nav aria-label="Page navigation" class="text-center" v-show="!loading">
  <ul class="pagination">
    <li :class="[reservations.prev_page_url ? '' : 'disabled']">
      <a href="#" aria-label="Previous" @click.prevent="getReservations(reservations.prev_page_url)">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li v-for="uv in reservations.page_range" track-by="$index" :class="[($index + 1) === reservations.current_page ? 'active' : '']">
      <a href="#" @click.prevent="getReservations(apiUrl+'?page='+($index + 1))">{{ $index + 1 }}</a>
    </li>
    <li :class="[reservations.next_page_url ? '' : 'disabled']">
      <a href="#" aria-label="Next" @click.prevent="getReservations(reservations.next_page_url)">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
  </nav>
</template>
<style>
  .glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
  }

  @-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
  }

  @keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
  }
</style>
<script>
  import axios from 'axios'
  import moment from 'moment'

  moment.locale('fr')

  export default {
    props: {
      root: String,
      auth: Boolean
    },
    data () {
      return {
        apiUrl: `${this.root}/api/reservations`,
        loading: false,
        form: {
          name: '',
          forename: ''
        },
        reservations: {}
      }
    },
    methods: {
      getReservations (url, params) {
        this.loading = true
        let that = this
        return axios.get(url, { params })
        .then((response) => {
          that.loading = false
          that.reservations = response.data
          that.reservations.page_range = Array(response.data.last_page).fill()
          that.reservations.data.forEach((element, index, array) => {
            element.arrive_at = moment(element.arrive_at)
            element.leave_at = moment(element.leave_at)
            array[index] = element
          })
        })
      },
      formSubmit () {
        let params = {}

        if (this.form.name) {
          params.name__eq = this.form.name
        }

        if (this.form.forename) {
          params.forename__eq = this.form.forename
        }

        if (params !== {}) {
          console.log(params)
          this.getReservations(this.apiUrl, params)
        }
      }
    },
    ready () {
      this.getReservations(this.apiUrl, {})
    }
  }
</script>
