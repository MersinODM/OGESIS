import { useAuthMutationTypes } from '../../utils/constants'
import { AbilityBuilder } from '@casl/ability'

export default (store) => {
  const { SET_USER, REMOVE_USER, AUTH } = useAuthMutationTypes()
  const ability = store.getters['auth/ability']
  const { can, rules } = new AbilityBuilder(ability)

  if (store.state.auth.user) {
    store.state.auth.user?.permissions.map(p => p.name)
      .forEach(claim => can(claim))
    ability.update(rules)
  }

  return store.subscribe((mutation) => {
    switch (mutation.type) {
      case SET_USER.withPrefix(AUTH): {
        mutation.payload.permissions.map(p => p.name)
          .forEach(claim => can(claim))
        ability.update(rules)
        break
      }
      case REMOVE_USER.withPrefix(AUTH):
        ability.update(['read'])
        break
    }
  })
}
