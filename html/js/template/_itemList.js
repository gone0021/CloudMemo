(function () {
   'use strict';
   Vue.component('item-list', {
      template: `<section id="itemList">

      <template v-for="(item, i) in items">
         <div class="itemTitle">
            <span>{{ item['title'] }}</span>
         </div>
         
         <div>
            <span v-for="(tag, j) in itemTags">タグ：{{ tag['tag_name'] }}</span>
         </div>


      </template>

      </section>`,
      props: ["userId",],
      data: function () {
         return {
            test: "",
            root: "",
            items: [],
            itemTags: [],
            getItems: {},
            getItemTags: {},
         }
      },
      created: function () {
         console.log("--- created item-list ---");

         this.getItemThen().then(() => {
            let items = [];
            this.items = this.getItems;
            items = this.items;

            let tags = [];
            for (var i=0; i<items.length; i++) {
               // this.getItemTagThen(items[i].id).then(() => {
               //    tags[i] = this.getItemTags;
               //    if (!tags[i].length) {
               //       tags[i] = null;
               //    }
               //    this.itemTags[i] = tags[i];
               //    // console.log(tags[i]);
               //    console.log(this.itemTags[i]);
               // });



               this.getItemTag(items[i].id);
               // tags[i] = this.itemTags;
               // console.log(tags[i]);
               
            }
         });

         
      },
      mounted: function () {
         console.log("--- mouted item-list ---");

         // this.getItem().then(() => {
         //    this.items = this.getItems;
         // });
      },
      methods: {


         // --- ajax method ---
         getItemThen: function () {
            return axios.get(`../app/api/get_item.php`, {
               params: {
                  user_id: this.userId,
               },
            }).then(
               function (res) {
                  this.getItems = res.data;
                  // console.log("getItem");
                  // console.log(this.getItems);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         getItemTagThen(id) {
            return axios.get(`../app/api/get_itemtag.php`, {
               params: {
                  item_id: id,
               },
            }).then(
               function (res) {
                  this.getItemTags = res.data;
                  // console.log("getItemTag");
                  // console.log(this.getItemTags);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },

         getItemTag(id) {
            axios.get(`../app/api/get_itemtag.php`, {
               params: {
                  item_id: id,
               },
            }).then(
               function (res) {
                  this.itemTags = res.data;
                  // console.log("getItemTag");
                  console.log(this.itemTags);
               }.bind(this)
            ).catch(function (e) {
               console.error(e);
            });
         },
      }

   });


})();