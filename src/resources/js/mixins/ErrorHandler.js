export default {
  data() {
    return {
      errors: {},
    };
  },
  methods: {
    error(name) {
      return this.errors[name] !== undefined;
    },
    message(name) {
      if (!this.error(name)) {
        return;
      }
      return this.errors[name];
    },
    addError(field, message) {
      this.errors[field] = message;
    },
    removeError(field) {
      if (this.errors[field]) {
        delete this.errors[field];
      }
    },
    addErrors(errors) {
      for (const key in errors) {
        if (errors.hasOwnProperty(key)) {
          this.errors[key] = errors[key][0];
        }
      }
    },
    clearErrors() {
      this.errors = {};
    },
  },
  computed: {
    hasError() {
      return Object.keys(this.errors).length > 0;
    },
  },
};