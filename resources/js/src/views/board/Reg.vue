<template>
    <div class="vx-row">
        <!-- MULTIPLE COLUMNS-->
        <div class="vx-col w-full mb-base">
            <vx-card title="등록/수정" code-toggler>
                <div class="vx-row">
                    <div class="vx-col w-full mb-6">
                        <vs-input class="w-full" v-validate="'required'" label-placeholder="제목" name="title" v-model="boardInfo.title"/>
                        <span class="text-danger text-sm" v-show="errors.has('title')">{{ errors.first('title') }}</span>
                    </div>
                </div>
                <div class="vx-row">
                    <div class="vx-col w-full mb-6">
                        <vs-input class="w-full" v-validate="'required'" label-placeholder="내용" name="content" v-model="boardInfo.content"/>
                        <span class="text-danger text-sm" v-show="errors.has('content')">{{ errors.first('content') }}</span>
                    </div>
                </div>
                <vs-divider/>
                <div class="vx-row">
                    <div class="vx-col w-full">
                        <vs-button class="mr-3 mb-2" @click="procReg">등록</vs-button>
                        <vs-button color="warning" type="border" class="mb-2" @click="procCancel">취소</vs-button>
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
                boardInfo: {}
            }
        },
        created() {
            if (!moduleBoard.isRegistered) {
                this.$store.registerModule('board', moduleBoard)
                moduleBoard.isRegistered = true
            }
            this.loadBoardInfo();
        },
        methods: {
            loadBoardInfo() {
                if (!this.$route.query.id) {
                    return false;
                }

                this.$store.dispatch("board/get", this.$route.query.id).then(result => {
                    this.boardInfo = this.$store.getters['board/getBoard'];
                });
            },
            procReg() {
                this.$validator.validateAll().then(result => {
                    if (!result) {
                        return false;
                    }

                    let dispatchType = (!!this.boardInfo.id) ? 'board/update' : 'board/create';
                    this.$store.dispatch(dispatchType, {'params': this.boardInfo})
                        .then(result => {
                            this.$router.push('/board/view?id=' + result.id);
                            return true;
                        })
                        .catch(error => {
                            console.log(error)
                        });
                })
            },
            procCancel() {
                this.$router.push({path: '/board'});
            }
        },
    }
</script>
