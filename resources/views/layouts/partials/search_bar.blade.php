<!--Search Bar-->
<input id="nav-search-bar-typeahead"
       class="form-control"
       type="search"
       v-model="name"
       v-on:keyup.enter="search"
       placeholder="Search...">

<input type="hidden"
       value="{{ request()->root() }}"
       v-model="request_uri">
