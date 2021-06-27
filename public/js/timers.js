window.Timer = new function() {

let m_timers = {};
let m_last_triggered = {};
let m_execution_queue = {};

const IsNotOnCD = function( slot, period ) {
   const time_to_next = (Me.last_triggered[slot] ?? (-period)) + period - (new Date().getTime());
   if( time_to_next <= 0 ) return true;
}
/*
const ExecuteTimer = function( slot ) {
   let serial = m_timers[slot].serial;
   m_timers[slot].executing = func( m_timers[slot].userdata );
   if( m_timers[slot].executing ) {
      m_timers[slot].executing.finally(() => {
         let after = m_timers[slot].after();
         delete m_timers[slot];
         m_last_triggered[slot] = getTime();
         if( m_timers[slot].after ) {
            after();
         }
      });
   } else {
      delete m_timers[slot];
      m_last_triggered[slot] = getTime();
   }
}*/

// We want to not overlap callbacks if they are async functions, so this is like a strand for them.
const Execute = async function( slot, func, userdata ) {
   const first = !m_execution_queue[slot];
   if( first ) m_execution_queue[slot] = [];
   const queue = m_execution_queue[slot];
   queue.push( func, userdata );
   if( !first ) return;
   
   console.log( m_execution_queue );
   console.log( 'starting' );
   while( queue.length > 0 ) {
      const f = queue.shift();
      const arg = queue.shift();
      console.log("executing fcallback", f);
      const promise = f( arg );
      console.log(promise);
      if( promise ) {
         await promise;
      }
   }
   console.log( "done" );
   delete m_execution_queue[slot];
}

//----------------------------------------------------------------------------------------
// Start a new timer.
// slot: Unique string ID for this timer.
// mode: How this timer works or reacts to additional Start calls.
// period: Seconds until the timer triggers.
// func: Callback function.
//
// Here are the different start modes:
//  "push"       Cancel existing timer. If you're using the same period and
//                function, you're "pushing" its execution back. This might
//                also make it faster if your new period is shorter.
//  "ignore"     Ignore the new call. If you try to start a new timer under a
//                slot that's already waiting, then it ignores you.
//  "duplicate"  Leave previous timer running and make new one. If you call
//                Start three times for a single tag, the previous two will
//                still trigger, and they cannot be canceled or otherwise 
//                modified at that point.
//  "cooldown"   This is like ignore, but it allows triggering instantly, if 
//                the last call wasn't done within the period specified. 
//                Otherwise, it's "on cooldown", and the timer behaves like 
//                "ignore" and the trigger time is fixed to 
//                last_trigger_time + period. Or in other words, it only allows
//                execution of a function every `period` seconds, and if it's
//                "on cooldown", it schedules a call for when the cooldown
//                expires. The callback will fire from this execution path
//                (inside Timer_Start) when not on cooldown.
const Start = function( slot, mode, period, func, userdata ) {
   if( mode == "cooldown" && !Me.timers[slot] ) {
      // Time until the cooldown expires.
      const time_to_next = (Me.last_triggered[slot] ?? (-period)) + period - (new Date().getTime());
      if( time_to_next <= 0 ) {
         // No cooldown, we can trigger instantly.
         m_last_triggered[slot] = (new Date().getTime());
         Execute( slot, func, userdata );
         return;
      }
      
      // Cooldown remains, ignore or schedule it.
      mode   = "ignore";
      period = time_to_next;
   }
   
   if( mode == "push" ) {
      // Cancel existing timer for "push".
      
      if( m_timers[slot] ) {
         Cancel( slot );
      }
   } else if( mode == "duplicate" ) {
      // Exiting timer will be forgotten and fire accordingly.
   } else {
      // "ignore"/default
      console.log(m_execution_queue, (m_execution_queue[slot] ?? []).length);
      if( m_timers[slot] || !!m_execution_queue[slot] ) {
         // Skip if timer already scheduled OR if the callback is still executing.
         // This can be used to skip duplicate requests when one is ongoing.
         return
      }
   }
   
   // This is the only data we need to expose to the outside, and we capture
   //  it inside our anonymous callback.
   m_timers[slot] = {
      userdata,
      timeoutHandle: setTimeout( function() {
         delete m_timers[slot];
         m_last_triggered[slot] = (new Date().getTime());
         Execute( slot, func, userdata );
      }, period * 1000 )
   }
}

//-----------------------------------------------------------------------------
// Cancels an existing timer. `slot` is what was passed to Timer_Start. Any
//  forgotten "duplicate" timers will not be cancelled.
const Cancel = function( slot ) {
   if( !m_timers[slot] ) return;
   clearTimeout( m_timers[slot].timeoutHandle );
   delete m_timers[slot];
}

this.IsNotOnCD = IsNotOnCD;
this.Start     = Start;
this.Cancel    = Cancel;

}();
