<template>
  <div class="repo-notes">
    <div class="repo-note-toolbar">
      <div class="toggle-edit-mode">
        <input type="checkbox" id="toggle-edit-mode" v-model="previewMode" />
        <label for="toggle-edit-mode"><i class="fa fa-eye"></i></label>
        <div class="toggle-hint">Toggle Preview Mode</div>
      </div>
    </div>
    <textarea class="repo-note-editor" @input="saveNotes | debounce 1000" v-model="currentNotes">{{ notes }}</textarea>
    <div class="repo-note-preview" v-show="previewMode">{{{ renderedNotes }}}</div>
  </div>
</template>
<script>
import Vue from "vue";
import highlight from "highlight.js";
import marked from "marked";
export default {
  name: "StarNotesEditor",
  props: ["notes"],
  data(){
    return {
      currentNotes: "",
      previewMode: this.hasNotes
    }
  },
  computed: {
    hasNotes(){
      return this.notes && this.notes.replace(/\s/g, "") !== "";
    },
    renderedNotes(){
      if( this.notes && this.notes.replace(/\s/g, "") !== "" ){
        return marked(this.notes);
      }
      else {
        return "";
      }
    }
  },
  methods: {
    saveNotes(){
      if( this.currentNotes && this.currentNotes.replace(/\s/g, "") !== "" ){
        this.$dispatch("NOTES_SAVED", this.currentNotes);
      }
    }
  },
  ready(){
    marked.setOptions({
      sanitize: true,
      breaks: true,
      highlight: (code) => {
        return highlight.highlightAuto(code).value;
      }
    });
  }
}
</script>
