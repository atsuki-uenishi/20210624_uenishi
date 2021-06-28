<template>
    <div class="home flex">
        <div class="action">
            <img class="logo" src="../assets/img/logo.png">
            <nuxt-link to="/home"><img  class="home-img" src="../assets/img/home.png">ホーム</nuxt-link>
            <div class="logout" @click="logout" to="/"><img class="logout-img" src="../assets/img/logout.png">ログアウト</div>
            <div class="share">
                <p class="white">シェア</p>
                <validation-provider v-slot="ProviderProps" rules="required|max:120">
                    <textarea v-model="shareContent" name="シェア" cols="30" rows="5" />
                    <div class="error">{{ ProviderProps.errors[0] }}</div>
                </validation-provider>
                <button class="btn" @click="insertPost">シェアする</button>
            </div>
        </div>
        <div class="timeline">
            <div class="content">ホーム</div>
            <div class="content" v-for="post in posts" :key="post.id">
                <div class="flex post">
                    <p>{{post.user.name}}</p>
                    <img class="timeline-img" :class="{'like-active' : likeactive}" @click="addLike(post.id, post.like, post.user.id)" src="../assets/img/heart.png">
                    <p>{{post.like}}</p>
                    <img class="timeline-img" @click="deletePost(post.id, post.user.id)" src="../assets/img/cross.png">
                    <img class="detail-img" @click="toDetail(post.id)" src="../assets/img/detail.png">
                </div>
                <p class="post-content">{{post.content}}</p>
            </div>
        </div>
    </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
    data() {
        return {
            userId: "",
            shareContent: "",
            posts: [],
            likeactive: false
        }
    },
    methods: {
        async getPosts() {
            const resData = await this.$axios.get(
                "http://127.0.0.1:8000/api/post/"
            );
            this.posts = resData.data.data;
        },
        async insertPost() {
            const sendData = {
                user_id: this.userId,
                content: this.shareContent
            };
            await this.$axios.post("http://127.0.0.1:8000/api/post/", sendData);
            this.shareContent = ""
            this.getPosts();
        },
        async addLike(id, like, postUserId) {
            if(this.userId !== postUserId) {
                if(this.likeactive === false){
                    const sendData = {
                    like: (like+1)
                    }
                    await this.$axios.put("http://127.0.0.1:8000/api/post/" + id, sendData);
                    this.likeactive = true;
                }else {
                    const sendData = {
                    like: (like-1)
                    }
                    await this.$axios.put("http://127.0.0.1:8000/api/post/" + id, sendData);
                    this.likeactive = false;
                }
                this.getPosts();
            }
        },
        async deletePost(id, postUserId) {
            const userId = this.userId;
            if(userId === postUserId) {
                await this.$axios.delete("http://127.0.0.1:8000/api/post/" + id);
                this.getPosts();
            }
        },
        toDetail(id) {
            this.$router.push({path: '/comment', query: {postId: id}})
        },
        logout() {
            firebase
                .auth()
                .signOut()
                .then(() => {
                    this.logoutIdSet()
                    alert('ログアウトが完了しました')
                })
        },
        async logoutIdSet() {
            await this.$store.commit('userIdSet', "")
            await this.$router.replace('/')
        }
    },
    created() {
        this.getPosts();
        this.userId = this.$store.state.userId;
    },
}
</script>

<style scoped>

.white {
    color:#fff;
    margin-bottom: 10px;
}
.flex {
    display: flex;
}
.action {
    width: 30%;
    margin-left: 20px;
    margin-right: 30px;
}
.logo {
    width: 150px;
    display: block;
    margin: 15px;
}

.action a {
    display: flex;
    color: #fff;
    text-decoration: none;
    margin-bottom: 10px;
    align-items: center;
    font-size: 1.1rem;
}
.logout {
    display: flex;
    color: #fff;
    text-decoration: none;
    margin-bottom: 10px;
    align-items: center;
    font-size: 1.1rem;
    cursor: pointer;
}
.logout-img {
    width: 45px;
    margin-right: 20px;
}
.home-img {
    width: 50px;
    margin-right: 15px;
}

.error {
    color: red;
}

.timeline {
    width: 100%;
}

.content{
    border-left: 1px solid #fff;
    border-bottom: 1px solid #fff;
    padding: 10px 15px;
    font-weight: bold;
    font-size: 1.2rem;
    color: #fff;
}
.timeline-img {
    width: 30px;
    height: 30px;
    margin: 0 10px;
    cursor: pointer;
}
.like-active {
    filter: invert(15%) sepia(95%) saturate(6932%) hue-rotate(276deg) brightness(95%) contrast(112%);
}
.detail-img {
    width: 30px;
    height: 30px;
    margin: 0 10px 0 80px;
    cursor: pointer;
}
.post {
    margin-top: 10px;
    font-weight: bold;
    height: 30px;
}
.post p{
    margin: 0 10px;
    height: 30px;
    padding-top: 5px;
}
.post-content {
    margin: 8px 0 5px 10px;
}
.btn {
    color: #fff;
    background-color: #3B14A7;
    padding: 10px 20px;
    border-radius: 30px;
    cursor: pointer;
    margin-bottom: 15px;
    margin: 0 0 0 auto;
    display: block;
    margin-top: 10px;
    }
textarea{
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #fff;
    background-color: #03256C;
    color: #fff;
    font-size: 1.1rem;
    outline: none;
    resize: none;
    border-radius: 10px;
    }
</style>