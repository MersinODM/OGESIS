import { useAuthMutationTypes, useBehaviorConstants } from '../../utils/constants'

export default (store) => {
  const { SET_USER, AUTH } = useAuthMutationTypes()
  const { BEHAVIOR, INIT, SET_CRUD } = useBehaviorConstants()

  // TODO Burada sıkıntı var vuex içinde vuecasl çalışmıyor
  return store.subscribe((mutation) => {
    if (mutation.type === AUTH.withSuffix(SET_USER)) {
      store.dispatch(BEHAVIOR.withSuffix(INIT))
      const init = () => {
        // Başlangıçta crud pasif hale getiriliyor
        store.dispatch(BEHAVIOR.withSuffix(SET_CRUD), false)
      }
      setTimeout(init, 500)
    }
  })
}
