import makeRestStore from 'fresh-bus/store/utils/makeRestStore'

export default ({ items, item }) => {
  return {
    ...makeRestStore(
      'companyMembers',
      { items, item },
    ),
    modules: {
      users: makeRestStore(
        'users',
        { items, item },
        {
          itemsPath: ({ companyId }) => `/foodfleet/companies/${companyId}/members`,
          itemPath: ({ companyId }) => `/foodfleet/companies/${companyId}/members`
        }
      ),
    }
  }
}
