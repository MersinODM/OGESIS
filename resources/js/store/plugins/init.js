import { useAuthMutationTypes, useBehaviorConstants } from '../../utils/constants'

export default (store) => {
  const { SET_USER, AUTH } = useAuthMutationTypes()
  const { BEHAVIOR, INIT } = useBehaviorConstants()

  // TODO Burada sıkıntı var vuex içinde vuecasl çalışmıyor
  return store.subscribe((mutation) => {
    if (mutation.type === AUTH.withSuffix(SET_USER)) {
      const init = () => store.dispatch(BEHAVIOR.withSuffix(INIT))
      setTimeout(init, 3000)
    }
  })
}
