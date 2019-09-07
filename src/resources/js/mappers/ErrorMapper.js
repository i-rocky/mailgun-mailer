export default {
  mapErrorsToClient(errors, prefix = '') {
    const mapped_errors = [];
    const keys = Object.keys(errors);
    for (const key of keys) {
      if (errors[key][0] === undefined) {
        const n_errors = this.mapErrorsToClient(errors[key], [prefix, key, '.'].join(''));
        for (const error of n_errors) {
          mapped_errors.push(error);
        }
        continue;
      }
      const error = {
        msg: errors[key][0],
        field: prefix + key,
      };
      mapped_errors.push(error);
    }
    return mapped_errors;
  },
};
