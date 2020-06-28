<template>
    <div id="game-round-result-list">
        <vx-card title="검색조건" class="user-list-filters mb-8">
            <div class="vx-row">
                <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
                    <label class="text-sm opacity-75">패턴검색</label>
                    <div class="flex flex-wrap w-full">
                        <v-select :options="searchFieldOptions" v-model="searchField" :clearable="false"/>
                        <vs-input class="mb-4 md:mb-0 mr-2" v-model="searchWord" @keyup.enter="procSearch" placeholder="검색어..."/>
                    </div>
                </div>
                <div class="vx-col md:w-3/4 sm:w-1/2 w-full">
                    <div class="w-full">

                    </div>
                </div>
            </div>

            <div class="vx-row">
                <vs-divider/>
                <div class="vx-col w-full text-center">
                    <vs-button type="filled" @click.prevent="procSearch">검색</vs-button>
                </div>
            </div>
        </vx-card>
        <vx-card title="회원목록" class="user-list-filters mb-8">
            <div class="flex flex-wrap justify-between items-center mb-4">
                <div class="mb-4 md:mb-0 mr-4 ag-grid-table-actions-left">
                    <v-select :options="pageSizeOptions" v-model="pageSizeOption" :clearable="false"/>
                </div>
                <div class="flex flex-wrap items-center justify-between ag-grid-table-actions-right">
                    <vs-button class="mb-4 md:mb-0" @click="goCreate">등록</vs-button>
                </div>
            </div>
            <vs-table
                    stripe
                    :sst="true"
                    @sort="procSort"
                    :data="boardList"
                    :noDataText="noDataText">
                <template slot="thead">
                    <vs-th sort-key="title">제목</vs-th>
                    <vs-th sort-key="created_at">등록일시</vs-th>
                    <vs-th sort-key="updated_at">수정일시</vs-th>
                </template>
                <template slot-scope="{data}">
                    <vs-tr :data="tr" :key="indextr" v-for="(tr, indextr) in data">
                        <vs-td :data="data[indextr].title"><span @click="goView(data[indextr].id)">{{data[indextr].title}}</span></vs-td>
                        <vs-td :data="data[indextr].created_at">{{data[indextr].created_at}}</vs-td>
                        <vs-td :data="data[indextr].updated_at">{{data[indextr].updated_at}}</vs-td>
                    </vs-tr>
                </template>
            </vs-table>
            <div class="mt-2">
                <vs-pagination :sst="true" :total="totalPage" v-model="currentPage" :max="maxPagination"></vs-pagination>
            </div>
        </vx-card>
    </div>
</template>

<script>
    import vSelect from 'vue-select'
    import moduleBoard from "@/store/board/moduleBoard";

    export default {
        components: {
            'v-select': vSelect
        },
        data: () => ({
            searchWord: '',
            searchField: {label: '제목', id: 'title'},
            searchFieldOptions: [
                {label: '제목', id: 'title'},
                {label: '내용', id: 'content'}
            ],
            orderBy: [],
            pageSizeOptions: [
                {label: '3개', id: '3'},
                {label: '5개', id: '5'},
                {label: '10개', id: '10'},
                {label: '20개', id: '20'},
                {label: '50개', id: '50'},
                {label: '100개', id: '100'},
            ],
            noDataText: '데이터가 없습니다.',
        }),
        created() {
            if (!moduleBoard.isRegistered) {
                this.$store.registerModule('board', moduleBoard)
                moduleBoard.isRegistered = true
            }
        },
        computed: {
            maxPagination() {
                let maxPagination = (this.$store.state.windowWidth >= 576) ? 10 : 5;
                return (this.totalPage < maxPagination) ? this.totalPage : maxPagination;
            },
            totalCount() {
                return this.$store.state.board.totalCount
            },
            totalPage: {
                get() {
                    return this.$store.state.board.totalPage
                },
                set(value) {
                    this.$store.commit('board/setTotalPage', value)
                }
            },
            currentPage: {
                get() {
                    return this.$store.state.board.currentPage
                },
                set(value) {
                    this.$store.commit('board/setCurrentPage', value)
                    this.getList()
                }
            },
            paginationPageSize: {
                get() {
                    return this.$store.state.board.paginationPageSize
                },
                set(value) {
                    this.$store.commit('board/setPaginationPageSize', value)
                    this.procSearch()
                }
            },
            boardList() {
                return this.$store.state.board.list
            },
            pageSizeOption: {
                get() {
                    return {label: this.paginationPageSize + '개', id: this.paginationPageSize};
                },
                set(val) {
                    this.paginationPageSize = val.id;
                }
            },
        },
        methods: {
            goView(id) {
                this.$router.push({path: '/board/view', query: {id: id}});
            },
            goCreate() {
                this.$router.push({path: '/board/reg'});
            },
            procSort(key, active) {
                this.orderBy = (!active) ? [] : [key, active];
                this.getList();
            },
            procSearch() {
                this.currentPage = 1;
            },
            getList() {
                this.$store.dispatch("board/list", {
                    'params': {
                        'searchWord': this.searchWord,
                        'searchField': this.searchField.id,
                        'ob_column': this.orderBy[0] || '',
                        'sort': this.orderBy[1] || ''
                    }
                })
            },
        }
    }
</script>
