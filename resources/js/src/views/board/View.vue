<template>
    <div class="vx-row">
        <!-- MULTIPLE COLUMNS-->
        <div class="vx-col w-full mb-base">
            <vx-card title="상세보기" code-toggler>
                <div class="vx-row">
                    <div class="vx-col w-full mb-6">
                        <vs-input class="w-full" v-validate="'required'" label-placeholder="제목" name="title" v-model="boardInfo.title" readonly=""/>
                    </div>
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full mb-6">
                        <vs-input class="w-full" v-validate="'required'" label-placeholder="내용" name="password" v-model="boardInfo.content" readonly=""/>
                    </div>
                </div>
                <div class="vx-row">
                    <div class="vx-col sm:w-1/2 w-full mb-6">
                        <vs-input class="w-full" v-validate="'required'" label-placeholder="등록일시" name="created_at" v-model="boardInfo.created_at" readonly=""/>
                    </div>
                    <div class="vx-col sm:w-1/2 w-full mb-6">
                        <vs-input class="w-full" v-validate="'required'" label-placeholder="수정일시" name="updated_at" v-model="boardInfo.updated_at" readonly=""/>
                    </div>
                </div>
                <vs-divider/>
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <vs-button class="mr-3 mb-2" @click="procReg">수정</vs-button>
                        <vs-button color="danger" type="border" class="mr-3 mb-2" @click="procDelete">삭제</vs-button>
                        <vs-button color="warning" type="border" class="mb-2" @click="goList">목록</vs-button>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
    import moduleBoard from "@/store/board/moduleBoard";

    export default {
        data() {
            return {
            }
        },
        computed: {
            boardInfo() {
                return this.$store.state.board.board
            },
        },
        created() {
            if(!moduleBoard.isRegistered) {
                this.$store.registerModule('board', moduleBoard)
                moduleBoard.isRegistered = true
            }
            this.loadBoardInfo();
        },
        methods: {
            loadBoardInfo() {
                this.$store.dispatch("board/get", this.$route.query.id)
            },
            procReg() {
                this.$router.push({path: '/board/reg', query: {id: this.boardInfo.id}});
            },
            procDelete() {
                this.$store.dispatch("board/delete", this.boardInfo.id)
                    .then(result => {
                        this.$router.push('/board');
                        return true;
                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            goList() {
                this.$router.push({path: '/board'});
            }
        },
        mounted() {
        },
    }
</script>
