<template>
  <div v-show="loading">
    <div class="ui active inverted dimmer">
      <div class="ui text loader">Chargement</div>
    </div>
  </div>

  <form class="ui form">
    <h3 class="ui dividing header">Filtres</h3>

    <div class="two fields">
      <div class="field">
        <label for="name">Nom</label>
        <input type="text" id="name" @change="formSubmit()" v-model="form.name" lazy>
      </div>

      <div class="field">
        <label for="forename">Prénom</label>
        <input type="text" id="forename" @change="formSubmit()" v-model="form.forename" lazy>
      </div>
    </div>

    <div class="field">
      <button @click.prevent="formSubmit()" class="ui button">Chercher</button>
      <button @click.prevent="clear()" class="ui button">Clear</button>
    </div>
  </form>

  <div class="ui divider"></div>

  <form class="ui form">
    <div class="field">
      <div class="ui container">
        <label>
          <input type="checkbox" @change="formSubmit()" v-model="validation">
          Uniquement les réservations validés
        </label>
      </div>
    </div>
  </form>

  <div class="ui divider"></div>

  <div class="ui divided items" v-show="!loading">
    <div class="item" v-for="reservation in reservations.data">
      <div class="content">
        <h1 class="header">{{ reservation.name }} {{ reservation.forename }}</h1>
        <div class="description">
          <p>
            Du <a href="{{ root + '/calendar/' + reservation.arrive_at.format('Y/M/D') }}">{{ reservation.arrive_at.format('D MMMM Y') }}</a> au
            <a href="{{ root + '/calendar/' + reservation.leave_at.format('Y/M/D') }}">{{ reservation.leave_at.format('D MMMM Y') }}</a>
            pour {{ reservation.nb_people }} personne(s).
          </p>
        </div>
        <div class="extra">
          <a class="ui button" href="{{ this.root }}/reservations/{{ reservation.id }}">Voir la réservation</a>
          <a v-if="auth" class="ui button" href="{{ this.root }}/reservations/{{ reservation.id }}/edit">Modifier la réservation</a>
        </div>
      </div>
    </div>
  </div>
  <div class="ui one column stackable center aligned page grid">
    <div class="column twelve wide">
      <div class="ui pagination menu center aligned" v-show="!loading">
        <a :class="[reservations.prev_page_url ? '' : 'disabled', 'item']" href="#" @click.prevent="getReservations(reservations.prev_page_url)">
          <span><i class="chevron left icon"></i></span>
        </a>
        <a v-for="uv in reservations.page_range" track-by="$index" :class="[($index + 1) === reservations.current_page ? 'active' : '', 'item']" href="#" @click.prevent="formSubmit({'page':($index + 1)})">
          {{ $index + 1 }}
        </a>
        <a :class="[reservations.next_page_url ? '' : 'disabled', 'item']" href="#" @click.prevent="getReservations(reservations.next_page_url)">
          <span><i class="chevron right icon"></i></span>
        </a>
      </div>
    </div>
  </div>
</template>
<style></style>
<script>
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
        validation: true,
        form: {
          name: '',
          forename: ''
        },
        reservations: {}
      }
    },
    methods: {
      buildQuery (params, url) {
        let queryString = ''
        for (var key in params) {
          queryString += `&${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`
        }
        if (url.indexOf('?') === -1) {
          queryString = queryString.replace('&', '?')
        }
        return (url + queryString)
      },
      getReservations (url, params) {
        if (!url) {
          return
        }

        if (params === undefined) {
          params = {}
        }

        if (this.validation) {
          params.valid = true
        }

        url = this.buildQuery(params, url)
        console.log('URL', url)
        this.loading = true
        let that = this
        this.$http.get(url)
          .then((response) => {
            that.loading = false
            that.reservations = response.json()
            that.reservations.page_range = Array(that.reservations.last_page).fill()
            that.reservations.data.forEach((element, index, array) => {
              element.arrive_at = moment(element.arrive_at)
              element.leave_at = moment(element.leave_at)
              array[index] = element
            })
          }, (response) => {
            console.error(response.statusText)
          })
      },
      clear () {
        this.form.name = ''
        this.form.forename = ''
        this.formSubmit()
      },
      formSubmit (params) {
        if (params === undefined) {
          params = {}
        }

        if (this.form.name) {
          params.name__eq = this.form.name
        }

        if (this.form.forename) {
          params.forename__eq = this.form.forename
        }

        this.getReservations(this.apiUrl, params)
      }
    },
    ready () {
      this.getReservations(this.apiUrl)
    }
  }
</script>
