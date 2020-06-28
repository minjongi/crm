export default {
    setListData(state, data) {
        state.list  = data.data || []
        state.totalPage = data.last_page || 1
        state.currentPage = data.current_page || 1
        state.paginationPageSize = data.per_page || 20
        state.totalCount = data.total || 0
    },
    setTotalPage(state, value) {
        state.totalPage = value
    },
    setCurrentPage(state, value) {
        state.currentPage = value
    },
    setPaginationPageSize(state, value) {
        state.paginationPageSize = value
    },
    setBoard(state, board) {
        state.board = board
    },
}
