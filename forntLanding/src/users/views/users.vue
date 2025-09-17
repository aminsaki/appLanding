<template>
  <div class="bg-gray-50">
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card p-4 shadow-lg">
            <div class="card-body">
              <!-- Title and Sub-Title -->
              <h1 class="text-center text-blue-500">{{ title }}</h1>
              <h2 class="text-center text-green-700">{{ subTitle }}</h2>
              <p class="text-center">{{ leadText }}</p>
               <div class="justify-content-center d-flex">
                 <img src="@/users/assets/logo.jpg"  class="img-fluid w-full" alt="">
               </div>
                <p class="p-2"></p>


              <!-- Questions -->
              <div v-for="(question, qIndex) in questions" :key="qIndex" class="mb-3">
                <h6 class="text-blue-400 text-green-700 p-2 text-bold text-danger">
                  {{ qIndex + 1 }}. {{ question.question }}
                </h6>
                <div v-for="(option, index) in question.options" :key="index" class="mb-2">
                  <button
                    class="btn w-full border rounded py-3 option-btn"
                    :class="{
                      'selected': selectedOptions[qIndex] === option.value,
                      'default': selectedOptions[qIndex] !== option.value
                    }"
                    @click="selectOption(qIndex, option.value)"
                  >
                    {{ option.text }}
                  </button>
                </div>
              </div>

              <!-- Progress Bar -->
              <div class="progress mt-3">
                <div class="progress-bar" role="progressbar" :style="{ width: progressBarWidth }"></div>
              </div>

              <!-- Show Results Button -->
              <button
                v-if="selectedOptions.length === questions.length"
                @click="saveResults"
                class="btn btn-primary w-full py-3 mt-4"
              >
                Reveal My Symphony
              </button>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, ref} from 'vue';
import { useRouter } from "vue-router";
import axios from "axios";
import { toRaw } from 'vue';
// Data for title, sub-title, and lead text
const title = "Symphony of Elpagina";
const subTitle = "Hair in Perfect Tune";
const leadText = "Every strand of your hair carries a note. Together, they compose the unique symphony of your beauty. Take this short journey, answer a few simple questions, and discover the music your hair is meant to play.";

// Question and answer data
const questions = [
  {
    question: 'What is your scalp type?',
    options: [
      {text: 'Dry and sensitive → Harp', value: 'Harp'},
      {text: 'Normal and balanced → Piano', value: 'Piano'},
      {text: 'Oily or prone to dandruff → Cello', value: 'Cello'}
    ]
  },
  {
    question: 'What is the main concern for your hair?',
    options: [
      {text: 'Thin or sparse → Cello', value: 'Cello'},
      {text: 'Dry or brittle strands → Harp', value: 'Harp'},
      {text: 'Imbalanced oiliness → Piano', value: 'Piano'}
    ]
  },
  {
    question: 'How often do you follow your personal hair care routine each week?',
    options: [
      {text: 'Less than 2 times → Piano', value: 'Piano'},
      {text: '3–4 times → Combination', value: 'Combination'},
      {text: 'Daily → Cello', value: 'Cello'}
    ]
  },
  {
    question: 'Which area do you focus on most for strengthening your hair?',
    options: [
      {text: 'Roots and follicles → Cello', value: 'Cello'},
      {text: 'Shaft and shine → Harp', value: 'Harp'},
      {text: 'Overall hair and scalp balance → Piano', value: 'Piano'}
    ]
  },
  {
    question: 'How would you describe your hair density?',
    options: [
      {text: 'High and healthy → Piano', value: 'Piano'},
      {text: 'Medium → Harp', value: 'Harp'},
      {text: 'Low, needs reinforcement → Cello', value: 'Cello'}
    ]
  },
  {
    question: 'What is your top priority for hair health?',
    options: [
      {text: 'Strength and root resilience → Cello', value: 'Cello'},
      {text: 'Softness and shine of the strands → Harp', value: 'Harp'},
      {text: 'Overall balance and harmony → Piano', value: 'Piano'}
    ]
  },
  {
    question: 'What type of professional hair products do you prefer?',
    options: [
      {text: 'Specialized treatments like mesotherapy → Cello', value: 'Cello'},
      {text: 'Nutrition and scalp/shaft massage → Harp', value: 'Harp'},
      {text: 'Balancing tonics and supplements → Piano', value: 'Piano'}
    ]
  },
  {
    question: 'What is the natural texture of your hair?',
    options: [
      {text: 'Straight and sleek → Piano', value: 'Piano'},
      {text: 'Wavy → Harp', value: 'Harp'},
      {text: 'Curly or voluminous → Cello', value: 'Cello'}
    ]
  },
  {
    question: 'How do your hair strands respond to treatments?',
    options: [
      {text: 'Fast and strong → Cello', value: 'Cello'},
      {text: 'Gentle and slow → Harp', value: 'Harp'},
      {text: 'Balanced and steady → Piano', value: 'Piano'}
    ]
  },
  {
    question: 'How would you describe the feeling of your hair?',
    options: [
      {text: 'Energetic and strong → Cello', value: 'Cello'},
      {text: 'Soft and luminous → Harp', value: 'Harp'},
      {text: 'Balanced and calm → Piano', value: 'Piano'}
    ]
  },
  {
    question: 'For maintaining hair health, which area do you focus on most?',
    options: [
      {text: 'Follicles and roots → Cello', value: 'Cello'},
      {text: 'Shaft and shine → Harp', value: 'Harp'},
      {text: 'Overall hair and scalp balance → Piano', value: 'Piano'}
    ]
  },
  {
    question: 'If you could compose a symphony for your hair, which would be the main instrument?',
    options: [
      {text: 'Cello → Power and depth', value: 'Cello'},
      {text: 'Harp → Softness and radiance', value: 'Harp'},
      {text: 'Piano → Harmony and balance', value: 'Piano'}
    ]
  }
];

// Reactive array to track selected options
let selectedOptions = ref(new Array(questions.length).fill(null));
let scores = ref({ C: 0, H: 0, P: 0 });
let result = ref('');

// Calculate progress bar width
const progressBarWidth = computed(() => {
  return `${(selectedOptions.value.filter(option => option !== null).length / questions.length) * 100}%`;
});

// Function to handle the selection
const selectOption = (qIndex, value) => {
  console.log("Selected option:", value); // برای بررسی مقدار انتخاب شده
  selectedOptions.value[qIndex] = value;

  // بررسی مقادیر امتیازها به صورت مستقیم
  console.log("Current scores:", toRaw(scores.value)); // برای نمایش درست مقادیر
};

// Function to calculate and determine the result based on scores
const calculateResult = () => {
  console.log("Calculating result...");

  // Update scores based on selected options
  selectedOptions.value.forEach(answer => {
    if (answer) {
      scores.value[answer[0]] += 1; // Increment score based on answer (C, H, P)
    }
  });

  // بررسی مقادیر بعد از بروزرسانی امتیازها
  console.log("Updated scores:", toRaw(scores.value));

  // Determine result (Solo, Duo, or Trio)
  const [maxInstrument, minInstrument] = Object.entries(scores.value).reduce(
    (acc, [instrument, score]) => {
      if (score > acc[0][1]) acc[0] = [instrument, score];
      if (score < acc[1][1]) acc[1] = [instrument, score];
      return acc;
    },
    [['C', 0], ['C', Infinity]]
  );

  console.log("Max instrument:", maxInstrument, "Min instrument:", minInstrument);

  // Check if there's a 2+ point difference between the highest and second highest score
  if (scores.value[maxInstrument] >= scores.value[minInstrument] + 2) {
    result.value = `${maxInstrument} Solo`;
  } else if (Math.max(...Object.values(scores.value)) - Math.min(...Object.values(scores.value)) <= 1) {
    result.value = 'Trio - The Complete Symphony';
  } else {
    // If difference is smaller than 2, consider Duo for the two most scored instruments
    const duoInstrument = Object.keys(scores.value).find(
      key => key !== maxInstrument && scores.value[key] === Math.max(...Object.values(scores.value).filter(val => val !== scores.value[maxInstrument]))
    );
    result.value = `${maxInstrument} + ${duoInstrument} Duo`;
  }
};

// Function to save results and show the result page
const saveResults = async () => {
  calculateResult();
  try {
    const response = await axios.post('/musicResults', {
      cello_score: scores.value.C,
      harp_score: scores.value.H,
      piano_score: scores.value.P,
      result: result.value,
    });

    const uid = response.data.uid;
    await router.push({
      name: 'result',
      query: {
        result: result.value,  // Pass the result message
        uid: uid
      }
    });
  } catch (error) {
    console.error('Error saving results:', error);
  }
};

const router = useRouter();
</script>

<style scoped>
/* Selected button styling */
.selected {
  background-color: #4CAF50 !important;
  color: white !important;
  font-weight: bold !important;
}

.default {
  background-color: #f0f0f0;
}

/* Option button styling */
.option-btn {
  font-size: 16px;
  font-weight: 500;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.option-btn:hover {
  transform: scale(1.05);
  background-color: #f1f1f1;
}

/* Progress bar styling */
.progress-bar {
  transition: width 0.3s ease;
}
</style>
