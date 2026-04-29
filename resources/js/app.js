import './bootstrap';
import Alpine from 'alpinejs';
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

window.Alpine = Alpine;
Alpine.start();

gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
