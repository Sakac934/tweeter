<template>
    <div class="tweet">

        <div class="tweet-content" style="font-size: 20px; color:#3B3B54; font-weight:bold; font-style: italic;">
            {{ tweet.tweet }}
        </div>
        <br />
        by - {{ tweet.user_id}} @
            </a> | {{ tweet.createdDate }}

        <br/>
        <input type="hidden" name="tweet_id" value="currentLoggedInUserUserId"/>
        <button :class="{'displaying': likeActive}" class="btn btn-xs likeUnlikeBtn" @click="likeTweet(tweet.id)" style="background-color: white; color:white; font-size:20px;"><i class="fa fa-heart" style="color:#2DB2F4;"></i></button> &nbsp;&nbsp;
        <button :class="{'displaying': unlikeActive}" class="btn btn-xs likeUnlikeBtn" @click="unlikeTweet(tweet.id)" style="background-color: white; color:white;"><i class="fa fa-heart" style="color:red; font-size:20px;"></i></button>

        {{tweet.number_of_likes}}

        <button @click.prevent="deleteTweet(tweet.id)" type="submit" class="btn btn-sm  btn-delete"  style="background-color: #1da1f2; color:white;">Delete</button>
        <comments-component :tweetId="tweet.id"></comments-component>
         <br />

         <commenting-component :tweetId="tweet.id"></commenting-component>

    </div>
</template>

<script>

export default {
    mounted() {
        console.log('Tweet Component mounted.')
        if(this.tweet.liked_by_user == '1'){
        this.unlikeActive = true;
        this.likeActive = false;
            this.makeComment();
            this.unlikeTweet();
            this.likeTweet();
            this.deleteTweet();
         }


    },
    data() {
        return{
            likeActive: true,
            unlikeActive: false,
        }
    },
    methods:{

        likeTweet(tweetId){
            if(this.tweet.liked_by_user == "1"){
            this.tweet.likes = parseInt(this.tweet.likes) + 1;

            this.tweet.number_of_likes,
             alert(currentLoggedInUserId);
            this.likeActive = false;
            this.unlikeActive = true;
            axios.post('/api/tweet-like',{
                tweet_id: tweetId,
                like: "1",
                comment: makeComment,
                user_id: currentLoggedInUserUserId
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    },
        unlikeTweet(tweetId){
            if(this.tweet.likes >0){
            this.tweet.likes = parseInt(this.tweet.likes) - 1;

            this.tweet.number_of_Unlikes,
             alert(currentLoggedInUserId);
            this.likeActive = true;
            this.unlikeActive = false;
            axios.post('/api/tweet-like',{
                tweet_id: tweetId,
                like: "0",
                comment: makeComment,
                user_id: currentLoggedInUserUserId
            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error){
                console.log(error);
            });
        }
    },
        deleteTweet(tweetId){
            alert('Are you sure you want to perform this action?');
            // console.log(this.deleteTweet);
            axios.post('/api/tweet-delete',{
                tweet_id: tweetId,
                user_id: currentLoggedInUserUserId

            })
            .then(function (response) {
                console.log(response);
            })
            .catch(function (error){
                console.log(error);
            });
        location.reload();
        }
    },
    props:['tweet']
}
</script>
