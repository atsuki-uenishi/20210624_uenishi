
export const state = () => ({
    userId: "b",
})

export const mutations = {
    userIdSet(state, payload) {
        state.userId = payload;
    },
}