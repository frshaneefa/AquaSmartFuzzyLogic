# -*- coding: utf-8 -*-
"""
Created on Mon Dec 12 01:22:19 2022

@author: user
"""

import numpy as np
from skfuzzy import control as ctrl
import skfuzzy as fuzz
import pickle

# Define the fuzzy sets for the inputs
water_level = ctrl.Antecedent(np.arange(0.0, 10.0, 0.01), 'water_level') # Update the range for water level in cm
water_flow = ctrl.Antecedent(np.arange(0, 101, 1), 'water_flow')

# Define the fuzzy sets for the output
pump_activation = ctrl.Consequent(np.arange(0, 101, 1), 'pump_activation')

# Update membership functions for water_level based on the new range in cm
water_level['low'] = fuzz.trimf(water_level.universe, [0.0, 0.0, 3.0])
water_level['medium'] = fuzz.trimf(water_level.universe, [2.0, 4.5, 7.0])
water_level['high'] = fuzz.trimf(water_level.universe, [6.0, 10.0, 10.0])

# Update membership functions based on the provided ranges
water_flow['low'] = fuzz.trimf(water_flow.universe, [0, 17, 34])
water_flow['medium'] = fuzz.trimf(water_flow.universe, [17, 34, 51])
water_flow['high'] = fuzz.trimf(water_flow.universe, [34, 51, 60])

water_level.view()
water_flow.view()

# Custom membership functions for pump_activation
pump_activation['low'] = fuzz.trimf(pump_activation.universe, [0, 0, 50])
pump_activation['medium'] = fuzz.trimf(pump_activation.universe, [0, 50, 100])
pump_activation['high'] = fuzz.trimf(pump_activation.universe, [50, 100, 100])

pump_activation.view()

# Define rules based on provided conditions
rule1 = ctrl.Rule(water_level['high'] & water_flow['high'], pump_activation['low'])
rule2 = ctrl.Rule(water_level['high'] & water_flow['medium'], pump_activation['low'])
rule3 = ctrl.Rule(water_level['high'] & water_flow['low'], pump_activation['low'])
rule4 = ctrl.Rule(water_level['medium'] & water_flow['high'], pump_activation['medium'])
rule5 = ctrl.Rule(water_level['medium'] & water_flow['medium'], pump_activation['medium'])
rule6 = ctrl.Rule(water_level['medium'] & water_flow['low'], pump_activation['low'])
rule7 = ctrl.Rule(water_level['low'] & water_flow['high'], pump_activation['high'])
rule8 = ctrl.Rule(water_level['low'] & water_flow['medium'], pump_activation['medium'])
rule9 = ctrl.Rule(water_level['low'] & water_flow['low'], pump_activation['low'])

# Control system and simulation
pump_activation_ctrl = ctrl.ControlSystem([rule1, rule2, rule3, rule4, rule5, rule6, rule7, rule8, rule9])
pump_activation_system = ctrl.ControlSystemSimulation(pump_activation_ctrl)

file = open('important.picl', 'wb')
pickle.dump(pump_activation_system, file)
file.close()

# Pass inputs to the control system using Antecedent labels with Pythonic API
pump_activation_system.input['water_level'] = 1.0  # Example input in cm
pump_activation_system.input['water_flow'] = 59    # Example input

# Crunch the numbers
pump_activation_system.compute()

# Print the result in a human-friendly form
print(pump_activation_system.output['pump_activation'])
