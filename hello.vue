<script setup>
import { ref, onMounted, computed } from 'vue';

// --- State Management ---
const skills = ref([]);
const loading = ref(false);
const newSkillName = ref('');

// --- Logic / Methods ---
const fetchSkills = async () => {
  loading.ref = true;
  try {
    // This would hit your PHP Controller's index method
    const response = await fetch('/api/skills');
    skills.value = await response.json();
  } catch (error) {
    console.error("Failed to load skills:", error);
  } finally {
    loading.value = false;
  }
};

const addSkill = () => {
  if (newSkillName.value.trim() === '') return;
  
  const skill = {
    id: Date.now(),
    name: newSkillName.value,
    folder: 'skills',
    fileName: 'SKILL.md' // Aligning with your naming convention
  };
  
  skills.value.push(skill);
  newSkillName.value = '';
};

// --- Lifecycle Hooks ---
onMounted(() => {
  fetchSkills();
});

// --- Computed Properties ---
const skillCount = computed(() => skills.value.length);
</script>

<template>
  <div class="skill-container">
    <h2>My Skills ({{ skillCount }})</h2>
    
    <input 
      v-model="newSkillName" 
      @keyup.enter="addSkill"
      placeholder="Enter new skill..."
    />
    
    <ul v-if="!loading">
      <li v-for="skill in skills" :key="skill.id">
        {{ skill.name }} - <small>{{ skill.folder }}/{{ skill.fileName }}</small>
      </li>
    </ul>
    <p v-else>Loading skills...</p>
  </div>
</template>

<style scoped>
.skill-container {
  padding: 20px;
  max-width: 400px;
}
</style>