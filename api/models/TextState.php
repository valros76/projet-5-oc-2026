<?php
class TextState
{
   public static function getTextStateParagraph(string $state = "await")
   {
      switch ($state) {
         case "finished":
            $state = "<p class='project-state-step-status' data-state='finished'><span class='project-state-step-status-icon'>🎯</span>Étape terminée</p>";
            break;
         case "validated":
            $state = "<p class='project-state-step-status' data-state='validated'><span class='project-state-step-status-icon'>✅</span>Étape validée</p>";
            break;
         case "in_progress":
            $state = "<p class='project-state-step-status' data-state='in_progress'><span class='project-state-step-status-icon'>⚙️</span>En cours</p>";
            break;
         case "await":
         case "on_hold":
         case "unknown":
         default:
            $state = "<p class='project-state-step-status' data-state='on_hold'><span class='project-state-step-status-icon'>⌛</span>En attente</p>";
            break;
      }
      return $state;
   }
}
