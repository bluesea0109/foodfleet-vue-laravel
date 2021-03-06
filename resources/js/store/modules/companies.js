import makeRestStore from '@freshinup/core-ui/src/store/utils/makeRestStore'

import busCompanies from 'fresh-bus/store/modules/companies'

export default ({ items, item }) => {
  const store = busCompanies({ items, item })
  return {
    ...store,
    namespaced: true,
    modules: {
      ...store.modules,
      squareLocations: makeRestStore(
        'squareLocations',
        { items, item },
        {
          itemsPath: ({ companyId }) => `/foodfleet/companies/${companyId}/square-locations`,
          itemPath: ({ companyId, id }) => `/foodfleet/companies/${companyId}/square-locations/${id}`
        }
      )
    }
  }
}
