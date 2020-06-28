import {cloneDeep} from "lodash";

export default {
    getBoard: state => {
        return cloneDeep(state.board);
    },
}
