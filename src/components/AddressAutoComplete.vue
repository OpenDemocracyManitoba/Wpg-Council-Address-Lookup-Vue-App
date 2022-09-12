<template>
  <div>
    <multiselect
      v-model="selected"
      :options="options"
      :searchable="true"
      :close-on-select="true"
      :clear-on-select="false"
      placeholder="Type a Winnipeg street and address"
      :loading="isLoading"
      label="display_address"
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
          return row;
        })
      }
      this.isLoading = false;
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
      return this.street_number + ' ' + this.street_name;
    },

    street_number() {
      if (!this.address) return '';

      const address_pattern = /(\d+)/;
      let address_matches = this.address.match(address_pattern);
      if (address_matches === null) return '';

      return address_matches[1];
    },

    street_name() {
      if (!this.address) return '';

      const address_pattern = /(\d+)\s+(.+)/;
      let address_matches = this.address.match(address_pattern);
      if (address_matches == null) return '';

      return address_matches[2].trim();
    },

  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<style>
</style>
