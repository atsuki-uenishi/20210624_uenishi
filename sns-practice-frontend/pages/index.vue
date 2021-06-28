<template>
  <div class="login">
    <Header />
    <div class="container">
      <h2 class="title">ログイン</h2>
      <validation-provider v-slot="ProviderProps" rules="email|required">
        <input type="email" v-model="email" name="email" placeholder="メールアドレス"/>
        <div class="error">{{ ProviderProps.errors[0] }}</div>
      </validation-provider>
      <validation-provider v-slot="ProviderProps" rules="min:6|required">
        <input type="password" v-model="password" name="password" placeholder="パスワード"/>
        <div class="error">{{ ProviderProps.errors[0] }}</div>
      </validation-provider>
      <button @click="login" class="btn">ログイン</button>
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
  data() {
    return{
      email: "",
      password: "",
      user:""
    }
  },
  methods: {
    async login() {
      if(!this.email || !this.password) {
        alert('メールアドレスまたはパスワードが入力されていません。')
        return
      }
      firebase
        .auth()
        .signInWithEmailAndPassword(this.email, this.password)
        .then(() => {
          alert('ログインが完了しました。')
          this.userId()
        })
        .catch((error) => {
          switch (error.code) {
            case 'auth/invalid-email':
              alert('メールアドレスの形式が違います。')
              break
            case 'auth/user-disabled':
              alert('ユーザーが無効になっています。')
              break
            case 'auth/user-not-found':
              alert('ユーザーが存在しません。')
              break
            case 'auth/wrong-password':
              alert('パスワードが間違っております。')
              break
            default:
              alert('エラーが起きました。しばらくしてから再度お試しください。')
              break
          }
        })
    },
    async userId() {
      const resData = await this.$axios.get("http://127.0.0.1:8000/api/user/", {params: {email: this.email}});
      this.user = resData.data.data;
      await this.$store.commit('userIdSet', this.user.id)
      await this.$router.push('/home')
    }
  },
  computed: {
  }
}
</script>

<style scoped>
.title{
  color: #000;
  font-size: 1.5rem;
  margin: 30px 0;
}
.login {
    width: 100%;
  }
  .container {
    margin: auto;
    width: 30%;
    height: auto;
    background-color: white;
    text-align: center;
    padding: 5px 10px;
  }
  input {
    display: block;
    margin: auto;
    width: 80%;
    height: 30px;
    margin-bottom: 15px;
    border-radius: 10px;
    font-size: 1.1rem;
    padding: 5px;
  }
  .btn {
    color: #fff;
    background-color: #3B14A7;
    padding: 10px 20px;
    border-radius: 30px;
    cursor: pointer;
    margin-bottom: 15px;
  }
  .error {
    margin-bottom: 5px;
    color: red;
  }
</style>