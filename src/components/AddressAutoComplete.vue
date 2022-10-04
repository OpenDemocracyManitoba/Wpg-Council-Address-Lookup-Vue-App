<template>
  <div>
    <multiselect
      v-model="selected"
      :options="options"
      :searchable="true"
      :close-on-select="true"
      :clear-on-select="false"
      placeholder="Enter your street number and name."
      :loading="isLoading"
      label="search_address"
      name="display_address"
      :preserveSearch="true"
      @select="selectAddress"
      @search-change="addressChanged">
          <template #noResult>No addresses found.</template>
    </multiselect>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import axios from 'axios';
const JSON_URL = 'https://data.winnipeg.ca/resource/cam2-ii3u.json';

export default {
  components: {
    Multiselect,
  },

  data() {
    return {
      selected: null,
      address: null,
      isLoading: false,
      options: [],
    }
  },

  methods: {
    selectAddress(address) {
      const obj = {
        address: address.display_address,
        school_division: address.school_division,
        school_division_ward: address.school_division_ward,
        ward: address.ward_as_of_september_17,
        street_number: address.street_number,
        street_name: address.street_name,
        street_direction: (address.street_direction) ? ' ' + address.street_direction : '',
      }
      this.$emit('selected',obj);
    },

    addressChanged(typed) {
      this.address = typed;
    },

    async fetchAddresses() {

      this.isLoading = true;
      let api_url = `${JSON_URL}?$where=street_number=${this.street_number} AND street_name LIKE "${this.street_name.toUpperCase()}%25"&$limit=10&$order=street_name ASC`;
      let return_obj = await axios.get(api_url);
      if (return_obj.data) {
        this.options = return_obj.data.map(row => {
          row.display_address = `${row.street_number} ${row.street_name} ${row.street_type}`;
          row.display_address += (row.street_direction) ? ' ' + row.street_direction : '';
          //search address is so the auto-complete finds the things they've typed
          row.search_address = '';
          if (this.suite_number) {
            row.search_address += this.suite_number;
          }
          row.search_address += `${row.street_number} ${row.street_name}`;
          if (this.street_type_converted) {
            //converted caught that its a valid street type, but put in whta they've actually typed so it catches in the autocomplete filter
            row.search_address += ` ${this.street_type}`
          }
          return row;
        })
      }
      this.isLoading = false;
    },

    convertStreetType(type) {
      type = type.toLowerCase().replace('.','');
      let dict = {
        "AVE":["ave","avenue"],
        "BAY":["bay"],
        "BLVD":["blvd","boulevard",],
        "CIR":["cir","circle"],
        "CLOSE":["close"],
        "COMMON":["common"],
        "COVE":["cove"],
        "CRES":["cres","crescent"],
        "CROSS":["cross"],
        "CRT":["crt","court"],
        "DR":["dr","drive"],
        "FWY":["fwy","freeway"],
        "GATE":["gate"],
        "GDN":["gdn","garden"],
        "GDNS":["gdns","gardens"],
        "GROVE":["grove"],
        "HWY":["hwy","highway"],
        "KEY":["key"],
        "LANE":["lane"],
        "MEWS":["mews"],
        "PATH":["path"],
        "PK":["pk","park","parc"],
        "PKY":["pky","parkway"],
        "PL":["pl","place"],
        "PROM":["prom","promenade"],
        "PT":["pt","point","pointe"],
        "RD":["rd","road"],
        "RIDGE":["ridge"],
        "ROW":["row"],
        "RUN":["run"],
        "SQ":["sq","square","squares"],
        "ST":["st","street"],
        "TERR":["terr","terrace","terrasse"],
        "TRAIL":["trail"],
        "WALK":["walk","walkway"],
        "WAY":["way"],
      }
      let reverse_dict = {};
      Object.keys(dict).forEach(key => {
        dict[key].forEach(value => {
          reverse_dict[value] = key;
        })
      })
      if (type in reverse_dict) {
        return reverse_dict[type];
      }
      let filtered = Object.keys(reverse_dict).filter(key => key.startsWith(type));
      if (filtered.length === 1) {
        return reverse_dict[filtered[0]];
      }
      return '';

    }
  },

  watch: {
    searchable_address() {
      if (this.street_number && this.street_name) {
        this.fetchAddresses();
      } else {
        this.options = [];
      }
    }
  },

  computed: {
    searchable_address() {
      return this.street_number + ' ' + this.street_name + ' ' + this.street_type;
    },

    street_number() {
      if (!this.address) return '';

      //const address_pattern = /(\d+)/;
      const address_pattern = /(.*-\s*)?(\d+)/;
      let address_matches = this.address.match(address_pattern);
      if (address_matches === null) return '';

      return address_matches[2];
    },

    suite_number() {
      if (!this.address) return '';

      const address_pattern = /(.*-\s*)?(\d+)/;
      let address_matches = this.address.match(address_pattern);
      if (address_matches === null) return '';
      return address_matches[1];
    },

    street_name() {
      if (!this.address) return '';

      const address_pattern = /(.*-\s*)?(\d+)\s+(.+)/;
      let address_matches = this.address.match(address_pattern);
      if (address_matches == null) return '';
      if (this.street_type_converted) {
        let pieces = address_matches[3].trim().split(/\s+/);
        pieces.length = pieces.length - 1;
        return pieces.join(' ');
      }
      return address_matches[3].trim();
    },

    street_type_converted() {
      return this.convertStreetType(this.street_type);
    },

    street_type() {
      if (!this.address) return '';
      const address_pattern = /(.*-)?(\d+)\s+(.+)/;
      let address_matches = this.address.match(address_pattern);
      if (address_matches == null) return '';
      let pieces = address_matches[3].trim().split(/\s+/);
      if (pieces.length > 1) {
        return pieces[pieces.length -1 ];
      }
      return '';

    }

  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style>
</style>
